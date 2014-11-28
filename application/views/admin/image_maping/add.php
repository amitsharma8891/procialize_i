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
//    $(document).ready(function() {
//        CKEDITOR.replace('coordinates',
//                {
//                    height: '500px'
////		extraPlugins : 'uicolor',
////                toolbar: [ [ 'Bold', 'Italic' ], [ 'UIColor' ] ]
//                });
//
//        $("#keyword_detail").change(function()
//        {
//            var keyword = $("#keyword_detail").val();
//            CKEDITOR.instances.email_temp_body.insertText(keyword);
//            CKEDITOR.instances.email_temp_body.insertHtml(CKEDITOR.instances.email_temp_body.getSelection().getNative())
//        });
//
//    });

            var SITE_URL = '<?php echo SITE_URL ?>';</script>
<div class="contentpanel"><!-- Content Panel -->
    <div class="col-sm-13"><!-- Add Exhibitor Row -->
        <form id="image_maping_form" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label class="col-sm-2 control-label">Event Name</label>
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
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Event Map Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name"  id ="name" class ="form-control " placeholder="Please Enter Maping Image Name" value="<?php echo $list->name ?>">
                    <input type="hidden" name="image_map_id" value="<?php echo $list->id ?>">
                    <span id="name_err" style="color: red"><?php echo $error->name; ?></span>
                </div>
            </div>

            <div class="form-group" style="display: none">
                <label class="col-sm-2 control-label">Parent Map</label>
                <div class="col-sm-6">
                    <?php
//                    echo "<pre>";
//                    print_r($parent_list);
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
                            }
                            ?>
                            <option <?php echo $seletcted ?> value = "<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
                            <?php
                            $i++;
                            ?>

                        <?php }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"> Event Map</label>
                <div class="col-sm-6">
                    <input type="file" name="image_name">
                    <span id="image_name_err" style="color: red"></span>
                    <?php if ($list->id) { ?>
                        <img src="<?php echo SITE_URL . 'uploads/event_image_maping/' . $list->image_name; ?>" height="200px" width="200px" />
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Co-ordinates for one or more Maps</label>
                <div class="col-sm-7">
                    <textarea rows="15" cols="50" name="coordinates" id="coordinates" class ="form-control" placeholder="Please Enter Image coordinates">
                        <?php echo $list->coordinates ?>
                    </textarea>
                    <span id="coordinates_err" style="color: red"></span>
                </div>
            </div>
            <div  class="form-group">
                <div class="col-sm-12">
                    <b> Sample:</b> 
<!--                    <div class="highlight">
                        <pre>
                        <code class="html">
                            <span class="cp">-->
            <xmp>
            <map name='Map' id='Map'>
                <area shape='circle' coords='733,233,89' rel='733,233,89' data-toggle='modal' data-target='#map_exhibitor'  href='javascript:void(0);' />
                <area shape='circle' coords='276,856,88' rel='276,856,88' data-toggle='modal' data-target='#map_exhibitor'  href='javascript:void(0);' />
            </map> 
            </xmp>
<!--                            </span>
                        </code>
                        </pre>
                    </div>-->
                    <b>  Guidelines:</b> 
            <xmp>
            1) Keep the <map name = "Map" id = "Map"> & </map> lines as it is.
            2) To highlight the area of the uploaded 'Event Map' image where other Maps or the Stalls can be associated, create one or more occurrences of 
                <area shape = "circle" coords = "733,233,89" rel = "733,233,89" data-toggle="modal" data-target="#map_exhibitor" href = "javascript:void(0);"/>
                Each of these defined area of co-ordinates can lead to another Map (Image) or can directly depict
                an Exhibitor Stall/Location.
            3) A Specialized UI/Technical person needs to work on this to arrive at these co-ordinates.
                Contact <?php echo getSetting()->contact_email; ?> if you need any assistance for the same.
            </xmp>
                </div>
            </div>
            <!--<div class = "iframe"><iframe></iframe></div> -->
            <div class = "form-group" >
<!--                <div class = "col-sm-4">
                    <a title = "Back" class = "btn btn-danger btn-block" href = "<?php echo base_url('manage/image_maping/'); ?>">Back</a>

                <input type = "button" class = "btn btn-danger btn-block" value = "Cancel"/> 
                </div>-->
                <div class = "col-sm-4 col-sm-offset-4">
                    <input type = "submit" class = "btn btn-success btn-block" value = "Save"/>
                </div>
            </div>
        </form>
    </div>
</div>
<script type = "text/javascript">
            $().ready(function() {

    jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
            $("#image_maping_form").validate({
    rules: {
    name: "required",
<?php if (!$list->id) {
    ?>
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
            form.submit();
            }

    });
    });
</script>