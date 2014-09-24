<script type="text/javascript" src="<?php echo SITE_URL; ?>public/admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/encoder.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/admin_email_template_module.js"></script>
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
        CKEDITOR.replace('email_temp_body',
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
        <form onsubmit="return false" id="email_template_form">
            <?php
            if (isset($list->id) && $list->id) {
                $disable = "disabled";
            } else {
                $disable = "";
            }
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Template for</label>
                <div class="col-sm-6">
                    <input type="text" <?php echo $disable; ?> name="temp_name"  id ="name" class ="form-control " placeholder="Please Enter Email Template Temp Name" value="<?php echo $list->temp_name ?>">
                    <span id="temp_name_err" style="color: red"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Template Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name"  id ="name" class ="form-control " placeholder="Please Enter Email Template Name" value="<?php echo $list->name ?>">
                    <input type="hidden" name="email_id" value="<?php echo $list->id ?>">
                    <span id="name_err" style="color: red"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Template Subject</label>
                <div class="col-sm-6">
                    <input type="text" name="subject"  id ="subject"  class ="form-control " placeholder="Please Enter Email Template Subject" value="<?php echo $list->subject ?>">
                    <span id="subject_err" style="color: red"></span>
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($list->id) && !empty($list->id)) { ?>
                    <div class="col-sm-3" style="float:right; resize: none; "><!-- Add Exhibitor Row -->
                        <?php
                        $options = explode(",", $list->keyword_detail);
                        ?>
                        <select type="select" name="keyword_detail" id="keyword_detail"  class="form-control chosen-select"> 

                            <?php
                            foreach ($options as $value) {
                                foreach ($keyword_deatail as $keyword_value) {
                                    if ($keyword_value['keyword'] == $value) {
                                        ?>
                                        <option value = "<?php echo $value ?>"><?php echo $keyword_value['detail']; ?></option>
                                        <?php
                                    } else {
                                        continue;
                                        ?>
                                        <!--<option value = "<?php echo $value ?>"><?php echo $value; ?></option>-->
                                        <?php
                                    }
                                }
                            }
                            ?>


                        </select>
    <!--                    <textarea rows="10" cols="40" name="keyword_detail" disabled>
                        <?php //echo $list->keyword_detail;  ?>
                        </textarea>-->
                    </div>
                <?php } ?>
                <label class="col-sm-2 control-label">Email Template Body</label>
                <div class="col-sm-7">
                    <textarea name="body" id="email_temp_body" class ="form-control  ckeditor" placeholder="Please Enter Email Template Body">
                        <?php echo $list->body ?>
                    </textarea>
                    <span id="body_err" style="color: red"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Template Name</label>
                <div class="col-sm-6">
<!--                    <select type="select" name="status" class="form-control chosen-select"> 
        <option> Status </option>
        <option value="1"> Status - Enabled </option>
        <option value="0"> Status - Disabled </option>
    </select>-->
                    <?php
                    $options = array(
                        1 => "Status - Enabled",
                        0 => "Status - Disabled"
                    );
                    ?>
                    <select type="select" name="status" id="status" class="form-control chosen-select"> 

                        <?php
                        $seletcted = "";
                        foreach ($options as $key => $value) {

                            if (isset($list->status)) {
                                if ($list->status == $key) {

                                    $seletcted = 'selected="selected"';
                                } else {
                                    $seletcted = "";
                                }
                            }
                            ?>
                            <option <?php echo $seletcted ?> value = "<?php echo $key ?>"><?php echo $value; ?></option>

                        <?php }
                        ?>
                    </select>
                </div>
            </div>

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