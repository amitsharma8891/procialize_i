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
                <h4 class="panel-title">Add Child Image map</h4>
                <p>By this You can Map Exhibitor in image</p>
            </div>

            <div class="panel-body panel-body-nopadding">

                <!-- BASIC WIZARD -->
                <script type="text/javascript" src="<?php echo SITE_URL; ?>public/admin/js/ckeditor/ckeditor.js"></script>
                <script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/encoder.js"></script>
                <!--<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/admin_image_maping_module.js"></script>-->
                <style>
                    textarea {
                        resize: none;
                    }
                    /*    #cke_1_contents {
                            height:500px;
                        }*/
                </style>
                <script>
                    $(document).ready(function() {
                        CKEDITOR.replace('coordinates',
                                {
                                    height: '500px'
                                            //		extraPlugins : 'uicolor',
                                            //                toolbar: [ [ 'Bold', 'Italic' ], [ 'UIColor' ] ]
                                });

                        $("#keyword_detail").change(function()
                        {
                            var keyword = $("#keyword_detail").val();
                            CKEDITOR.instances.email_temp_body.insertText(keyword);
                            CKEDITOR.instances.email_temp_body.insertHtml(CKEDITOR.instances.email_temp_body.getSelection().getNative())
                        });

                    });

                    var SITE_URL = '<?php echo SITE_URL ?>';
                </script>
                <div class="contentpanel"><!-- Content Panel -->
                    <div class="col-sm-13"><!-- Add Exhibitor Row -->
                        <form id="image_maping_form" enctype="multipart/form-data" method="POST">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Maping Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name"  id ="name" class ="form-control " placeholder="Please Enter Maping Image Name" value="<?php echo $list->name ?>">
                                    <input type="hidden" name="image_map_id" value="<?php echo $list->id ?>">
                                    <input type="hidden" name="event_id" id="event_id" value="<?php echo $list->event_id ?>">
                                    <input type="hidden" name="child_coords" id="child_coords" value="">
                                    <span id="name_err" style="color: red"><?php echo $error->name; ?></span>
                                </div>
                            </div>
                            <!--                            <div class="form-group">
                                                            <label class="col-sm-2 control-label">Maping event</label>
                                                            <div class="col-sm-6">
                            <?php
//                    echo "<pre>";
//                    print_r($event_list); 
                            ?>
                                                                <select type="select" name="event_id" class="form-control chosen-select"> 
                            <?php
                            $seletcted = "";

                            foreach ($event_list as $key => $value) {
                                if (isset($list->event_id)) {
                                    if ($list->event_id == $value['id']) {
                                        $seletcted = 'selected="selected"';
                                    } else {
                                        $seletcted = "";
                                    }
                                }
                                ?>
                                                                            <option <?php echo $seletcted ?> value = "<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
                                
                            <?php }
                            ?>
                                                                </select>
                                                            </div>
                                                        </div>-->
                            <!--                            <div class="form-group">
                                                            <label class="col-sm-2 control-label">Parent Map</label>
                                                            <div class="col-sm-6">
                            <?php
//                    echo "<pre>";
//                    print_r($event_list); 
                            ?>
                                                                <select type="select" name="parent_id" class="form-control chosen-select"> 
                            <?php
                            $seletcted = "";
                            $i = 0;
                            foreach ($parent_list as $key => $value) {
                                if (isset($list->parent_id)) {
                                    if ($list->parent_id == $value['id']) {
                                        $seletcted = 'selected="selected"';
                                    } else {
                                        $seletcted = "";
                                    }
                                }
                                if ($i == 0) {
//                                if (isset($list->parent_id) && $list->parent_id != 0) {
                                    ?>
                                                                                    <option value = "0">Select Parent Map Image</option>
                                    <?php
//                                }
                                } else {
                                    ?>
                                                                                    <option <?php echo $seletcted ?> value = "<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                }
                                $i++;
                                ?>
                                
                            <?php }
                            ?>
                                                                </select>
                                                            </div>
                                                        </div>-->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> Mapping Image</label>
                                <div class="col-sm-6">
                                    <input type="file" name="image_name">
                                    <span id="image_name_err" style="color: red"></span>
                                    <?php if ($list->id) { ?>
                                        <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="200px" width="200px" />
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="col-sm-2 control-label">Image coordinates</label>
                                <div class="col-sm-7">
                                    <textarea name="coordinates" id="coordinates" class ="form-control  ckeditor" placeholder="Please Enter Image coordinates">
                                        <?php echo $list->coordinates ?>
                                    </textarea>
                                    <span id="coordinates_err" style="color: red"></span>
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
            $("#child_coords").val(coords);

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
//                    alert(res.exhibitor_id);
                    $("#exhibitor_id option[value='" + res.exhibitor_id + "']").attr('selected', 'selected');
//                    $("#exhibitor_id ").chosen();
//                    $("#exhibitor_id ").val(res.exhibitor_id);
//                    $('#exhibitor_id').trigger("liszt:updated")
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