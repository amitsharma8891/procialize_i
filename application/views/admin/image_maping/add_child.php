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
                <h4 class="panel-title">Add/Update Sub-Map </h4>
                <p>Associate an Exhibitor Stall or any other Venue/Location on the Event Map. If you associate an Exhibitor with this location, users will have direct option to view profile of that Exhibitor.</p>
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
//                    $(document).ready(function() {
//                        CKEDITOR.replace('coordinates',
//                                {
//                                    height: '500px'
//                                            //		extraPlugins : 'uicolor',
//                                            //                toolbar: [ [ 'Bold', 'Italic' ], [ 'UIColor' ] ]
//                                });
//
//                        $("#keyword_detail").change(function()
//                        {
//                            var keyword = $("#keyword_detail").val();
//                            CKEDITOR.instances.email_temp_body.insertText(keyword);
//                            CKEDITOR.instances.email_temp_body.insertHtml(CKEDITOR.instances.email_temp_body.getSelection().getNative())
//                        });
//
//                    });

                            var SITE_URL = '<?php echo SITE_URL ?>';</script>
                <div class="contentpanel"><!-- Content Panel -->
                    <div class="col-sm-13"><!-- Add Exhibitor Row -->
                        <form id="image_maping_form" enctype="multipart/form-data" method="POST">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Event Map Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name"  id ="name" class ="form-control " placeholder="Please Enter Maping Image Name" value="">
                                    <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $list->id ?>">
                                    <input type="hidden" name="child_id" id="child_id" value="">
                                    <input type="hidden" name="image_photo_id" id="image_photo_id" value="">
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
                                <label class="col-sm-2 control-label"> Mapped Image</label>
                                <div class="col-sm-6">
                                    <input type="file" name="image_name" id="select_image_name">
                                    <span id="image_name_err" style="color: red"></span>
                                    <div id="edit_child_image">
                                        <?php if ($list->id) { ?>
                                                                                                                                                                                                                                        <!--<img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="150px" width="150px" />-->
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="col-sm-2 control-label">Image Coordinates</label>
                                <div class="col-sm-7">
                                    <textarea name="coordinates" id="coordinates" class ="form-control" placeholder="Please Enter Image coordinates">
                                        <?php //echo $list->coordinates  ?>
                                    </textarea>
                                    <span id="coordinates_err" style="color: red"></span>
                                </div>
                            </div>
                <!--            <div class="iframe"><iframe></iframe></div>-->


                            <div class = "form-group"  id="button_fields">
                                <div class = "col-sm-4">
                                    <a title="Back"  onclick="modal_close()" class = "btn btn-danger btn-block">Back</a>

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
//            $("#coordinates").val(coords);
            $("#child_coords").val(coords);
            child_coords = coords;
            get_exibitor(child_coords);
    });
    });
            function get_exibitor(child_coords = NULL) {
            var map_id = $('#parent_id').val();
                    var event_id = $('#event_id').val();
                    var child_coords = $('#child_coords').val();
                    $.ajax({
                    type: 'POST',
                            url: '<?php echo SITE_URL; ?>' + "manage/image_maping/get_child_image_map",
                            dataType: 'json',
                            data: {
                            map_id: map_id, event_id: event_id, child_coords: child_coords
                            },
                            success: function(res)
                            {
                            if (res.exhibitor_response) {
                            $('#delete_button').remove();
                                    $('#name').val('');
                                    $('#description').html('');
                                    $('#image_photo_id').val('0');
                                    $('#edit_child_image').html('');
                                    $('#coordinates').html('');
                                    $('#child_id').val('');
                                    alert('These co-ordinates already have a Stall/Location tagged to it');
                                    $('#map_exhibitor').modal('hide');
                            }
                            if (res.status) {
                            alert('Exhibitor For this Coordinates is already added');
                                    window.location.href = SITE_URL + "manage/image_maping/add_child/" + map_id;
                            }
                            if (res.id) {
//                    alert(res.coordinates);
                            $("#exhibitor_id option[value='" + res.exhibitor_id + "']").attr('selected', 'selected');
                                    $('#name').val(res.name);
                                    var image = '<img src="<?php echo SITE_URL . 'uploads/event_image_maping/'; ?>' + res.image_name + '" height="150px" width="150px" />';
                                    $('#edit_child_image').html(image);
                                    $('#parent_id').val(res.parent_id);
                                    $('#delete_button').remove();
                                    var button_html = "<div class = 'col-sm-4' id='delete_button'> <a title='Delete' class = 'btn btn-danger btn-block' href='<?php echo SITE_URL . 'manage/image_maping/delete/'; ?>" + res.id + "'>Delete</a></div>";
                                    $('#button_fields').append(button_html);
                                    $('#child_id').val(res.id);
                                    $('#image_photo_id').val('1');
                                    $('#event_id').val(res.event_id);
                                    $('#child_coords').val(res.child_coords);
                                    $('#coordinates').html(res.coordinates);
//                    $('#coordinates').val(res.coordinates);
                                    $("#exhibitor_id").trigger("liszt:updated");
                            } else {
                            $('#name').val('');
                                    $('#delete_button').remove();
                                    $('#description').html('');
                                    $('#image_photo_id').val('0');
                                    $('#edit_child_image').html('');
                                    $('#coordinates').html('');
                                    $('#child_id').val('');
                            }
                            }
                    });
            }
    function modal_close() {
    $('#map_exhibitor').modal('hide');
    }
</script>
<script type = "text/javascript">
    $().ready(function() {

    jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
            $("#image_maping_form").validate({
    rules: {
    name: "required",
<?php if (!$list->id) { ?>
        image_name: "required",
<?php } ?>
    coordinates: "required",
    },
            messages: {
            name: "Please enter your Map Name",
<?php if (!$list->id) { ?>
                image_name: "Please Select Image",
<?php } ?>
            coordinates: "Please enter your Coordinates",
            },
            submitHandler: function(form) {
            var image_photo_id = $('#image_photo_id').val();
                    var select_image_name = $('#select_image_name').val();
                    if (select_image_name == ""){
            if (image_photo_id == 0){
            $("#image_name_err").html("Please Select image !!");
                    return false;
            } else{
            $("#image_name_err").html("");
            }
            } else{
            $("#image_name_err").html("");
            }
            form.submit();
            }

    });
    });
</script>