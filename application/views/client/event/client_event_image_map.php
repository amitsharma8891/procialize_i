  
<?php $this->load->view(CLIENT_HEADER) ?>

<!----event top navigation---->
<?php $this->load->view(EVENT_TOP_NAVIGATION) ?>
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
                            <h4 class="tits_1"><?php //echo $event['event_name']                                                                      ?></h4>
                            <div class="row">
                                <div class="col-xs-12">
                                    <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" usemap="#Map" > <!--class='img-responsive'-->
                                    <!--<img src="<?php //echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name;                         ?>" height="50px" width="50px">-->
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
    <?php //$this->load->view(CLIENT_RIGHT_PANEL)  ?>
    <!--Right panel view--->
</div><!-- rightpanel -->




</section>
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
                                    <?php //echo $list->coordinates        ?>
                                 </textarea>-->
                                    <span id="description_err" style="color: red"></span>
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
        <?php } ?>
    </div>
</div>
<?php $this->load->view(CLIENT_FOOTER) ?>
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
        if (map_id == "") {
            map_id = $('#image_map_id').attr("data-value");
        }
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
                            $("#exhibitor_id").html(val.name);
                            var image = '<img style="float:right;" src="' + SITE_URL + 'uploads/attendee/' + val.photo + '" width="10%" height="10%">';
                            if (val.photo == '' || val.photo == null) {
                                image = '<img style="float:right;" src="' + SITE_URL + 'uploads/attendee/default.jpg" width="10%" height="10%">';
                            }
                            var exhibitor_detail_link = '<a href=' + SITE_URL + "events/exhibitor-detail/" + res.exhibitor_id + '> View Exhibitor </a>';
                            $("#image").html(image);
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
                // console.clear();
            }
        });
    }

</script>