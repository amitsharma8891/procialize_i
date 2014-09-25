<?php ?>


<div class="contentpanel"><!-- Content Panel -->
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
<!--<script>
    var coordinates = coords;
    $('area').click(function() {
        var coords = $(this).attr('coords');
        $("#coordinates").val(coords);
        coordinates = coords;
    });
</script>-->
<div class="modal fade" id="map_exhibitor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

                <!-- BASIC WIZARD -->
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
                        <!--                        <div class="form-group">
                                                    <label class="col-sm-2 control-label"> Mapping Image</label>
                                                    <div class="col-sm-6">
                                                        <input type="file" name="image_name">
                                                        <span id="image_name_err" style="color: red"></span>
                                                        <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="200px" width="200px" />
                                                    </div>
                                                </div>-->
                        <div class="form-group">

                            <label class="col-sm-3 control-label">Descriptions </label>
                            <div class="col-sm-7">
                                <textarea name="description" id="description" class ="form-control" placeholder="Please Enter Image Map Description">
                                    <?php //echo $list->coordinates ?>
                                </textarea>
                                <span id="description_err" style="color: red"></span>
                            </div>
                        </div>
            <!--            <div class="iframe"><iframe></iframe></div>-->


                        <div class = "form-group">
                            <div class = "col-sm-4">
                                <a title="Back" class = "btn btn-danger btn-block" href="<?php echo base_url('manage/email_template/'); ?>">Back</a>

                    <!--<input type = "button" class = "btn btn-danger btn-block" value = "Cancel"/>-->
                            </div>
                            <div class = "col-sm-4">
                                <input type = "submit" class = "btn btn-success btn-block" value = "Save"/>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- #basicWizard -->

            </div><!-- panel-body -->
        </div><!-- panel -->
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

</script>