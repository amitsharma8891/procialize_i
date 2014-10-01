<!--<div class="contentpanel"> Content Panel 
<?php if (!empty($list)) {  //echo '<pre>'; print_r($list); 
    ?>
                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                            <div class="col-sm-12 col-md-12">
                                                                                                                                                                                                <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" usemap="#Map">
    <?php echo $list->coordinates; ?>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
    <?php
} else {
    echo 'No Image Map event Present';
}
?>
</div>
<script>
    var coordinates = coords;
    $('area').click(function() {
        var coords = $(this).attr('coords');
        $("#coordinates").val(coords);
        coordinates = coords;
    });
</script>
<div class="modal fade" id="map_exhibitor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                </div>
                <h4 class="panel-title">Map Exhibitor</h4>
                <p>By this You can Map Exhibitor in image</p>
            </div>

            <div class="panel-body panel-body-nopadding">

                 BASIC WIZARD 
                <div id="basicWizard" class="basic-wizard">
                    <form id="image_maping_form" enctype="multipart/form-data" method="POST">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Maping Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name"  id="name" class ="form-control " placeholder="Please Enter Maping Image Name" value=""/>
                                <input type="hidden" id="image_map_id" name="image_map_id" value="<?php echo $list->id ?>">
                                <input type="hidden" id="coordinates" name="coordinates" value="">
                                <input type="hidden" id="map_exhibitor_id" name="map_exhibitor_id" value="">
                                <input type="hidden" id="event_id" name="event_id" value="<?php echo $list->event_id ?>">
                                <span id="name_err" style="color: red"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Maping event</label>
                            <div class="col-sm-6">
<?php
//                    echo "<pre>";
//                    print_r($event_list); 
?>
                                <select type="select" id="exhibitor_id" name="exhibitor_id" class="form-control chosen-select"> 
<?php
$seletcted = "";

foreach ($exhhibitor_list as $key => $value) {
    if (isset($list->exhibitor_id)) {
        if ($list->exhibitor_id == $value['attendee_id']) {
            $seletcted = 'selected="selected"';
        } else {
            $seletcted = "";
        }
    }
    ?>
                                                                                                                                                                                                                        <option <?php echo $seletcted ?> value = "<?php echo $value['attendee_id'] ?>"><?php echo $value['name']; ?></option>

<?php }
?>
                                </select>
                            </div>
                        </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"> Mapping Image</label>
                                                    <div class="col-sm-6">
                                                        <input type="file" name="image_name">
                                                        <span id="image_name_err" style="color: red"></span>
                                                        <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="200px" width="200px" />
                                                    </div>
                                                </div>
                        <div class="form-group">

                            <label class="col-sm-3 control-label">Descriptions </label>
                            <div class="col-sm-7">
                                <textarea name="description" id="description" class ="form-control" placeholder="Please Enter Image Map Description">
<?php //echo $list->coordinates ?>
                                </textarea>
                                <span id="description_err" style="color: red"></span>
                            </div>
                        </div>
                        <div class="iframe"><iframe></iframe></div>


                        <div class = "form-group">
                            <div class = "col-sm-4">
                                <a title="Back" class = "btn btn-danger btn-block" href="<?php echo base_url('manage/email_template/'); ?>">Back</a>

                    <input type = "button" class = "btn btn-danger btn-block" value = "Cancel"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type = "submit" class = "btn btn-success btn-block" value = "Save"/>
                            </div>
                        </div>
                    </form>

                </div>
                 #basicWizard 

            </div> panel-body 
        </div> panel 
    </div>
</div>
<script>
    var coordinates;
    $(document).ready(function() {

        $('area').click(function() {
            var coords = $(this).attr('coords');
            $("#coordinates").val(coords);
            coordinates = coords;
            get_exibitor(coordinates);

        });
    });
    function get_exibitor(coordinates = NULL) {
        var map_id = $('#image_map_id').val();
        var event_id = $('#event_id').val();
        var coordinates = $('#coordinates').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo SITE_URL; ?>' + "manage/image_maping/get_exhibitor",
            dataType: 'json',
            data: {
                map_id: map_id, event_id: event_id, coordinates: coordinates
            },
            success: function(res)
            {
                if (res.id) {
                    $("#exhibitor_id option[value='" + res.exhibitor_id + "']").attr('selected', 'selected');
                    $('#name').val(res.name);
                    $('#image_map_id').val(res.map_id);
                    $('#map_exhibitor_id').val(res.id);
                    $('#event_id').val(res.event_id);
                    $('#coordinates').val(res.coordinates);
                    $('#description').html(res.description);
                } else {
                    $('#name').val('');
                    $('#description').html('');
                }
            }
        });
    }

</script>-->


<!---client header view--->
<?php $this->load->view(CLIENT_HEADER) ?>

<!---client header view--->


<!----event top navigation---->
<?php $this->load->view(EVENT_TOP_NAVIGATION) ?>
<!----event top navigation---->
</div>
<?php //display($list)?>
<?php if (!empty($list)) { ?>
    <div class="contentpanel">
        <div class="panel panel-default panel-stat">
            <div class="">

                <div class="row">

                    <div class="col-xs-12">
                        <div class="stat well well-sm">
                            <h4 class="tits_1"><?php //echo $event['event_name']                                             ?></h4>
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" usemap="#Map">
                                    <!--<img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="50px" width="50px">-->
                                    <!--        left: rpos.x, 306,194,503,353
                                                top: rpos.y-->
                                    <?php echo $list->coordinates; ?>
                                    <input type="hidden" id="image_map_id" name="image_map_id" value="<?php echo $list->id ?>">
                                    <input type="hidden" id="coordinates" name="coordinates" value="">
                                    <input type="hidden" id="map_exhibitor_id" name="map_exhibitor_id" value="">
                                    <input type="hidden" id="event_id" name="event_id" value="<?php echo $list->event_id ?>">

                                </div>
                                <div class="col-xs-8 eventdet">
                                    <span class="pull-right mr10">
                                        <small class="stat-label">
                                            <!--                                        <div class="thumb">
                                                                                        <img src="<?php echo SITE_URL . 'uploads/organizer/logo/' . $event['organiser_photo'] ?>" class="img-responsive userlogor" alt="Organizer"/>
                                                                                    </div>-->
                                        </small>

                                    </span>

                                </div>
                            </div><!-- row -->
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
                                google.maps.event.addDomListener(window, 'resize', initialize);</script>

                            <!---google map integrations ends---->
                                          <!--<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php //echo $event['event_latitude']                                               ?>,<?php //echo $event['event_longitude']                                               ?>&zoom=14&size=400x400&sensor=false" class="img-responsive thumb mapimg mb9">-->



                            <?php
                            if (!passcode_validatation()) {
                                ?>
                                <!--<a href="javascript:;" data-toggle="modal" data-target="#SignUp" class="btn btn-success input-sm btn-block mb9">Event Registration</a>-->
                            <?php } ?>

                        </div><!-- stat -->
                    </div><!-- col-sm-6 -->

                </div><!-- row -->
            </div>
        </div>
    </div><!-- contentpanel -->
<?php } else { ?>
    <div class="contentpanel">
        <div class="panel panel-default panel-stat">
            <div class="">

                <div class="row">

                    <div class="col-xs-12">
                        <div class="stat well well-sm">
                            <h4 class="tits_1"></h4>
                            <div class="row" style="text-align: center">
                               
                                    There is no Mapped image available for this event!!
                            </div> 
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div>
<?php } ?>
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
<div class="modal fade" id="map_exhibitor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="panel panel-default">
            <?php if (empty($exhhibitor_list)) { ?>
                <div style="font-size: 27px;padding: 14px;color: red"> There is no Exhibitor taged with this Event!
                </div>
            <?php } else { ?>
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                    </div>
                    <h4 class="panel-title">Map Exhibitor</h4>
                    <p>By this You can see Exhibitor on Map</p>
                </div>
                <div class="panel-body panel-body-nopadding">
                    <!-- BASIC WIZARD -->
                    <div id="basicWizard" class="basic-wizard">
                        <form id="image_maping_form" enctype="multipart/form-data" method="POST">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div id="image" ></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Exhibitor Name : </label>
                                <div class="col-sm-6">
                                    <div id="name" ></div>
                                    <!--<input type="text" name="name"  id="name" class ="form-control " placeholder="Please Enter Maping Image Name" value=""/>-->
                                    <input type="hidden" id="image_map_id" name="image_map_id" value="<?php echo $list->id ?>">
                                    <input type="hidden" id="coordinates" name="coordinates" value="">
                                    <input type="hidden" id="map_exhibitor_id" name="map_exhibitor_id" value="">
                                    <input type="hidden" id="event_id" name="event_id" value="<?php echo $list->event_id ?>">
                                    <span id="name_err" style="color: red"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Maped Exhibitor Name : </label>
                                <div class="col-sm-6" id="exhibitor_id">
                                </div>
                            </div>
                            <!--                        <div class="form-group">
                                                        <label class="col-sm-2 control-label"> Mapping Image</label>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="image_name">
                                                            <span id="image_name_err" style="color: red"></span>
                                                            <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="200px" width="200px" />
                                                        </div>
                                                    </div>-->
                            <div class="form-group">

                                <label class="col-sm-3 control-label">Descriptions : </label>
                                <div class="col-sm-7">
                                    <div id="description"></div>
    <!--                                    <textarea name="description" id="description" class ="form-control" placeholder="Please Enter Image Map Description">
                                    <?php //echo $list->coordinates      ?>
                                 </textarea>-->
                                    <span id="description_err" style="color: red"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- #basicWizard -->
                </div><!-- panel-body -->
            </div><!-- panel -->
        <?php } ?>
    </div>
</div>
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
<script>
    var coordinates;
    var SITE_URL = '<?php echo SITE_URL; ?>';
    $(document).ready(function() {
        $('area').click(function() {
            var coords = $(this).attr('coords');
            $("#coordinates").val(coords);
            coordinates = coords;
            get_exibitor(coordinates);
        });
    });
    function get_exibitor(coordinates = NULL) {
        var map_id = $('#image_map_id').val();
        var event_id = $('#event_id').val();
        var coordinates = $('#coordinates').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo SITE_URL; ?>' + "manage/image_maping/get_exhibitor",
            dataType: 'json',
            data: {
                map_id: map_id, event_id: event_id, coordinates: coordinates
            },
            success: function(res)
            {
                var SITE_URL = '<?php echo SITE_URL; ?>';
                if (res.id) {
//                    $("#exhibitor_id option[value='" + res.exhibitor_id + "']").attr('selected', 'selected');
                    if (res.parent_id) {
                        window.location.href = SITE_URL + "client/event/get_image_map_exhibitor/child/" + res.id;
                    }

                    $('#name').html(res.name);
                    $('#image_map_id').val(res.map_id);
                    $('#map_exhibitor_id').val(res.id);
                    $('#event_id').val(res.event_id);
                    $('#coordinates').val(res.coordinates);
                    $('#description').html(res.description);
//                    $("#exhibitor_id").trigger("liszt:updated");
                    $.each(res.exhhibitor_list, function(i, val) {
                        if (val.attendee_id == res.exhibitor_id) {
                            $("#exhibitor_id").html(val.name);
                            var image = '<img style="float:right;" src="' + SITE_URL + '/uploads/attendee/' + val.photo + '">';
                            $("#image").html(image);
                        }
                    });
                } else {
                    $('#name').html('');
                    $('#description').html('');
                    $('#exhibitor_id').html('');
                    $('#image').html('');
                }
                // console.clear();
            }
        });
    }

</script>