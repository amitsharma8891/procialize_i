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
                    <span id="name_err" style="color: red"><?php echo $error->name; ?></span>
                </div>
            </div>
            <div class="form-group">
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
            </div>
            <div class="form-group">
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
                                    <option value = "0">Select Parent</option>
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
            </div>
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
<script>
//    (function($, undefined) {
//        $.fn.getCursorPosition = function() {
////            alert('fdgdfgfdg');
//            var el = $(this).get(0);
//            var pos = 0;
//            console.log(el);
////            var etstst  = el.getSelection().getRanges();
////            alert(etstst);
//            if ('selectionStart' in el) {
//                pos = el.selectionStart;
//                console.log(document);
////            } else if ('selection' in document) {
//                el.focus();
//                var Sel = document.selection.createRange();
//                var SelLength = document.selection.createRange().text.length;
//                Sel.moveStart('character', -el.value.length);
//                pos = Sel.text.length - SelLength;
//                pos
//            }
//            return pos;
//        }
//    })(jQuery);
//    $('#name').click(function() {
//
//        var position = $("#email_temp_body").getCursorPosition()
//        alert(position);
//    });

//
//    var content = $('#email_temp_body').val();
//    var newContent = content.substr(0, position) + "text to insert" + content.substr(position);
//    $('#email_temp_body').val(newContent);
</script>