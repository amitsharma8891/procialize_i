<?php $this->load->view(CLIENT_HEADER) ?>
<!----event top navigation---->
<?php $this->load->view(EVENT_TOP_NAVIGATION) ?>
<!--<script src="<?php echo SITE_URL ?>public/admin/js/jquery.imagemaps.min.js" type="text/javascript"></script>-->  
<script src="<?php echo SITE_URL ?>public/client/plugins/maphilight/mapster.js" type="text/javascript"></script>  
<!----event top navigation---->
</div>


<?php
if (!empty($list)) {
    ?>
    <div class="contentpanel">
        <div class="panel panel-default panel-stat">
            <div class="">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="stat well well-sm">
                            <h4 class="tits_1"><?php //echo $event['event_name']                                                                                                                                              ?></h4>
                            <div class="row">
                                <div class="col-xs-12">
                                    <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" usemap="#Map" class="img-responsive map" > <!--class='img-responsive'-->
                                    <!--<img src="<?php //echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name;                                                                                                 ?>" height="50px" width="50px">-->
                                    <?php echo $list->coordinates; ?>
                                    <input type="hidden" id="image_map_id" name="image_map_id" data-value='<?php echo $list->id ?>' value="<?php echo $list->id ?>">
                                    <input type="hidden" id="coordinates" name="coordinates" value="">
                                    <input type="hidden" id="map_exhibitor_id" name="map_exhibitor_id" value="">
                                    <input type="hidden" id="event_id" name="event_id" value="<?php echo $list->event_id ?>">

                                </div>
                                <div class="col-xs-8 eventdet">
                                    <span class="pull-right mr10">
                                        <small class="stat-label">

                                        </small>

                                    </span>

                                </div>
                            </div><!-- row -->
                            <br>
                            <!---google map integrations---->



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
<?php } ?><!-- contentpanel -->

</div><!-- mainpanel -->

<div class="rightpanel">
    <!--Right panel view--->
    <?php $this->load->view(CLIENT_RIGHT_PANEL) ?>
    <!--Right panel view--->
</div><!-- rightpanel -->




</section>
<div class="modal fade" id="map_exhibitor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="panel panel-default">
            <?php //if (empty($exhhibitor_list)) {   ?>
            <!--                <div style="font-size: 27px;padding: 14px;color: red;text-align: center;"> No Data Found!
                            </div>-->
            <?php //} else {   ?>
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                </div>
                <h4 class="panel-title">Map Location/Exhibitor Stall</h4>
                <p></p>
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
                        <!--                            <div class="form-group">
                                                        <label class="col-sm-3 control-label">Exhibitor Name : </label>
                                                        <div class="col-sm-6">
                                                            <div id="name" ></div>
                                                            <input type="text" name="name"  id="name" class ="form-control " placeholder="Please Enter Maping Image Name" value=""/>
                                                            <input type="hidden" id="image_map_id" name="image_map_id" value="<?php echo $list->id ?>">
                                                            <input type="hidden" id="coordinates" name="coordinates" value="">
                                                            <input type="hidden" id="map_exhibitor_id" name="map_exhibitor_id" value="">
                                                            <input type="hidden" id="event_id" name="event_id" value="<?php echo $list->event_id ?>">
                                                            <span id="name_err" style="color: red"></span>
                                                        </div>
                                                    </div>-->

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description : </label>
                            <div class="col-sm-7">
                                <div id="description"></div>
                                <span id="description_err" style="color: red"></span>
                            </div>
                        </div>
                        <div class="form-group" id="exhibitor_name_div">
                            <label class="col-sm-3 control-label"> Exhibitor Name : </label>
                            <div class="col-sm-6" id="exhibitor_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-7">
                                <div id="view_exhibitor"></div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- #basicWizard -->
            </div><!-- panel-body -->
        </div><!-- panel -->
        <?php //}   ?>
    </div>
</div>
<?php $this->load->view(CLIENT_FOOTER) ?>
<script type="text/javascript">
    var coordinates;
    var SITE_URL = '<?php echo SITE_URL; ?>';

    $(document).ready(function() {
        get_exibitor();
        $('area').live('click', function() {
            var coords = $(this).attr('rel');
            $("#coordinates").val(coords);
            coordinates = coords;
            get_exibitor(coordinates);
        });

        var resizeTime = 100;     // total duration of the resize effect, 0 is instant
        var resizeDelay = 100;
        $('img').mapster({
            fillColor: '000000',
            scaleMap: true,
            key: 0,
            mapKey: 'data-key',
        });
        function resize(maxWidth, maxHeight) {
            var image = $('img'),
                    imgWidth = image.width(),
                    imgHeight = image.height(),
                    newWidth = 0,
                    newHeight = 0;

            if (imgWidth / maxWidth > imgHeight / maxHeight) {
                newWidth = maxWidth;
            } else {
                newHeight = maxHeight;
            }
            image.mapster('resize', newWidth, newHeight, resizeTime);
        }

// Track window resizing events, but only actually call the map resize when the
// window isn't being resized any more

        function onWindowResize() {

            var curWidth = $(window).width(),
                    curHeight = $(window).height(),
                    checking = false;
            if (checking) {
                return;
            }
            checking = true;
            window.setTimeout(function() {
                var newWidth = $(window).width(),
                        newHeight = $(window).height();
                if (newWidth === curWidth &&
                        newHeight === curHeight) {
                    resize(newWidth, newHeight);
                }
                checking = false;
            }, resizeDelay);
        }

        $(window).bind('resize', onWindowResize);
        var cordinates_value = '';
<?php
$session_test = 0;
$mapped_exhibitor_coordinates = $this->session->userdata('mapped_exhibitor_coordinates');
if (isset($mapped_exhibitor_coordinates) && !empty($mapped_exhibitor_coordinates)) {
    ?>
            cordinates_value = '<?php echo $mapped_exhibitor_coordinates; ?>';
            $('img').mapster('set', true, cordinates_value);
    <?php
}
?>

    });
    function get_exibitor(coordinates) {
        var map_id = $('#image_map_id').val();
        if (map_id == "") {
            map_id = $('#image_map_id').attr("data-value");
        }
        var event_id = $('#event_id').val();
        var coordinates = $('#coordinates').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo SITE_URL; ?>' + "client/event/get_exhibitor",
            dataType: 'json',
            data: {
                map_id: map_id, event_id: event_id, coordinates: coordinates
            },
            success: function(res)
            {
                var SITE_URL = '<?php echo SITE_URL; ?>';
                if (res.exhhibitor_name == "" || res.exhhibitor_name == 'undefined' || res == "") {
                    $('#exhibitor_name_div').hide();
                } else {
                    $('#exhibitor_name_div').show();
                }
                if (res.id) {
//                    $("#exhibitor_id option[value='" + res.exhibitor_id + "']").attr('selected', 'selected');
                    if (res.parent_id) {
                        $('#map_exhibitor').modal('hide');
                        window.location.href = SITE_URL + "client/event/get_image_map_exhibitor/child/" + res.id;
                    }
                    if (res.exhhibitor_name == "" || res.exhhibitor_name == 'undefined') {
                        $('#exhibitor_name_div').hide();
                    }
                    $('#name').html(res.name);
                    $('#image_map_id').val(res.map_id);
                    if (res.child_map_id != 0) {
                        $('#image_map_id').val(res.child_map_id);
                    }
                    $('#map_exhibitor_id').val(res.id);
                    $('#event_id').val(res.event_id);
                    $('#coordinates').val(res.coordinates);
                    $('#description').html(res.description);
//                    $("#exhibitor_id").trigger("liszt:updated");
                    $.each(res.exhhibitor_list, function(i, val) {

                        if (val.attendee_id == res.exhibitor_id) {
                            var image = '<img style="float:left;margin-right:15px;" src="' + SITE_URL + 'uploads/exhibitor/' + res.exhhibitor_logo + '" width="10%" height="10%">';
                            if (res.exhhibitor_logo == '' || res.exhhibitor_logo == null) {
                                image = '<img style="float:left;margin-right:15px;" src="' + SITE_URL + 'uploads/attendee/default.jpg" width="10%" height="10%">';
                            }
                            var exhibitor_detail_link = '<a href=' + SITE_URL + "events/exhibitor-detail/" + res.exhibitor_id + '> View Detail </a>';
//                            $("#image").html(image);


                            $("#exhibitor_id").html(image + "    " + res.exhhibitor_name);
                            $("#view_exhibitor").html(exhibitor_detail_link);
                        }
                    });
                } else {
                    $('#name').html('');
                    $('#description').html('');
                    $('#exhibitor_id').html('');
                    $('#image').html('');
                    $('#view_exhibitor').html('');
                }
                console.clear();
            }
        });
    }
    setTimeout(function()
    {
        expire_session();
    }, 3000);
    function expire_session(coordinates) {
        var session_name = 'mapped_exhibitor_coordinates';
        $.ajax({
            type: 'POST',
            url: '<?php echo SITE_URL; ?>' + "client/event/expire_session",
            dataType: 'json',
            data: {
                session_name: session_name
            },
            success: function(res)
            {
                console.clear();
            }
        });
    }

</script>
<?php //$this->session->unset_userdata('mapped_exhibitor_coordinates');  ?>
