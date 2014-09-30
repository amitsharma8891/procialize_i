<script src="<?php echo SITE_URL ?>public/client/jsvalidation/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo SITE_URL ?>public/client/jsvalidation/screen.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<div class="contentpanel"><!-- Content Panel -->
    <?php
    if (!empty($list)) {  //echo '<pre>'; print_r($list); 
        if ($list->parent_id == 0) {
            ?>
            <div class="row mb20"><!-- Exhibitor Row -->
                <div class="col-sm-12 col-md-12">
                    <button class="btn btn-success btn-block" onclick="window.location = '<?php echo base_url('manage/image_maping/add_child/' . $list->id); ?>'">Add Child Image map</button>
                </div>
            </div>
        <?php }
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
<div class="modal fade" id="map_exhibitor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="panel panel-default">
            <?php if (empty($exhhibitor_list)) { ?>
                <div style="font-size: 27px;padding: 14px;color: red"> There is no Exhibitor to tag with this Event!
                </div>
            <?php } else { ?>
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
                                <label class="col-sm-3 control-label">Exhibitor Name</label>
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
                                <label class="col-sm-3 control-label">Maping event Exhibitor</label>
                                <div class="col-sm-6">
                                    <?php if (empty($exhhibitor_list)) { ?>
                                        <div style="color: red"> Their is no Exhibitor to tag with this coordinates!
                                        </div>
                                    <?php } else { ?>
                                        <select  id="exhibitor_id" name="exhibitor_id" class="form-control"> 
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
                                                <option value = "<?php echo $value['attendee_id'] ?>"><?php echo $value['name']; ?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    <?php } ?>
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
                                        <?php //echo $list->coordinates    ?>
                                    </textarea>
                                    <span id="description_err" style="color: red"></span>
                                </div>
                            </div>
                            <div class = "form-group">
                                <div class = "col-sm-4">
                                    <a title="Back" class = "btn btn-danger btn-block" href="<?php echo base_url('manage/image_maping/'); ?>">Back</a>
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
        <?php } ?>
    </div>
</div>
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
                if (res.id) {
                    $("#exhibitor_id option[value='" + res.exhibitor_id + "']").attr('selected', 'selected');
                    if (res.parent_id) {
                        window.location.href = SITE_URL + "manage/image_maping/map_exhibitor/" + res.id;
                    }
                    $('#name').val(res.name);
                    $('#image_map_id').val(res.map_id);
                    $('#map_exhibitor_id').val(res.id);
                    $('#event_id').val(res.event_id);
                    $('#coordinates').val(res.coordinates);
                    $('#description').html(res.description);
                    $("#exhibitor_id").trigger("liszt:updated");
                } else {
                    $('#name').val('');
                    $('#description').html('');
                }
            }
        });
    }

</script>
<style>
    #exhibitor_id{display:block !important;}
    #exhibitor_id_chosen{display:none !important;}
</style>
<script type = "text/javascript">
    $().ready(function() {

        jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
        $("#image_maping_form").validate({
            rules: {
                name: "required",
                exhibitor_id: "required",
                description: "required",
            },
            messages: {
                name: "Please enter your Map Name",
                exhibitor_id: "Please Select Exhibitor",
                description: "Please enter your Description",
            },
            submitHandler: function(form) {
                form.submit();
            }

        });
    });
</script>