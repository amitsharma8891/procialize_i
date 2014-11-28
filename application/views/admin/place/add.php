<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/encoder.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/admin_place_module.js"></script>
<script>
    var SITE_URL = '<?php echo SITE_URL ?>';
</script>
<?php
//display($list);
//display($country_list);
?>
<div class="contentpanel"><!-- Content Panel -->
    <div class="col-sm-13"><!-- Add Exhibitor Row -->
        <form onsubmit="return false" id="email_template_form">
            <?php if ($country_city_type == 'city') { ?>
                <div class="form-group" >
                    <label class="col-sm-2 control-label">Country Name</label>
                    <div class="col-sm-6">
                        <?php
//            $options = array(
//                1 => "Status - Enabled",
//                0 => "Status - Disabled"
//            );
                        ?>
                        <select type="select" name="country_id" id="country_id" class="form-control chosen-select"> 

                            <?php
                            $seletcted = "";
                            foreach ($country_list as $key => $value) {

                                if (isset($list->country_id)) {
                                    if ($list->country_id == $value['id']) {

                                        $seletcted = 'selected="selected"';
                                    } else {
                                        $seletcted = "";
                                    }
                                }
                                ?>
                                <option <?php echo $seletcted ?> value = "<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>

                            <?php }
                            ?>
                        </select>
                    </div> 
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo ucfirst($country_city_type . ' Name'); ?></label>
                <div class="col-sm-6">
                    <input type="text" name="name"  id ="name" class ="form-control " placeholder="<?php echo 'Please Enter ' . ucfirst($country_city_type) . ' Name'; ?>" value="<?php echo $list->name ?>">
                    <input type="hidden" name="place_id"  id ="place_id" class ="form-control "  value="<?php echo $list->id ?>">
                    <span id="name_err" style="color: red"></span>
                </div>
            </div>



            <div class = "form-group">
                <div class = "col-sm-4">
                    <a title="Back" class = "btn btn-danger btn-block" href="<?php echo base_url('manage/place/'); ?>">Back</a>

                    <!--<input type = "button" class = "btn btn-danger btn-block" value = "Cancel"/>-->
                </div>
                <div class = "col-sm-4">
                    <input type = "submit" class = "btn btn-success btn-block" value = "Save"/>
                </div>
            </div>
        </form>
    </div>


</div>
