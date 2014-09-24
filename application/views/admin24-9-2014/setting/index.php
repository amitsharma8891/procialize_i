<script type="text/javascript">
    var SITE_URL = '<?php echo SITE_URL ?>';
</script>
<style type="text/css">
    .error{color:red}
</style>
<script type="text/javascript" src="<?php echo CLIENT_PLUGINS ?>plupload/plupload.full.js"></script>    
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/logo_image.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/background_image.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/slider_image.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/admin_setting_module.js"></script>

<div class="contentpanel">
    <!-- Content Panel -->

    <div class="row mb20"><!-- Exhibitor Row -->

    </div>
    <?php //echo '---->'.getSetting()->id;//display(getSetting());
    ?>
    <div class="row mb10"><!-- Add Exhibitor Row -->
        <div class="form-group">
            <h3 class="col-sm-12">General Information</h3>
        </div>
        <form onsubmit="return false" id="setting_form">
            <div class="form-group">
                <div class="col-sm-6">
                    <label>
                        <div>App Name <span class="field_required">*</span></div>
                    </label>
                    <input type="text" name="app_name" placeholder="App Name" class="form-control" value="<?php echo $setting['app_name'] ?>">
                    <span class="error" id="app_name_err"></span>
                </div>
                <div class="col-sm-6">
                    <label>
                        <div>Owner Name <span class="field_required">*</span></div>
                    </label>
                    <input type="text" name="owner_name" placeholder="Owner Name" class="form-control" value="<?php echo $setting['app_owner_name'] ?>">
                    <span class="error" id="owner_name_err"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label>
                        <div>Company Name </div>
                    </label>
                    <input type="text" name="company_name" placeholder="Company Name" class="form-control" value="<?php echo $setting['app_company_name'] ?>">
                    <span class="error" id="company_name_err"></span>
                </div>
                <div class="col-sm-6">
                    <label>
                        <div>Twitter Hash Tag </div>
                    </label>
                    <input type="text" name="twitter_hash_tag" placeholder="Twitter Hash Tag" class="form-control" value="<?php echo $setting['app_twitter_hash_tag'] ?>">
                    <span class="error" id="twitter_hash_tag_err"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label>
                        <div>Apple store link</div>
                    </label>
                    <input type="text" name="apple_app_store" placeholder="Apple store link" class="form-control" value="<?php echo $setting['apple_app_store'] ?>">
                    <span class="error" id="apple_app_store_err"></span>
                </div>
                <div class="col-sm-6">
                    <label>
                        <div>Google play store link</div>
                    </label>
                    <input type="text" name="google_play_store" placeholder="Google play store link" class="form-control" value="<?php echo $setting['google_play_store'] ?>">
                    <span class="error" id="google_play_store_err"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">


                    <div class="form-group">
                        <label class="control-label">Primary Color</label><br />
                        <input type="text" name="primary_color" class="form-control colorpicker-input" id="colorpicker" value="<?php echo $setting['app_primary_color'] ?>">
                        <span id="colorSelector" class="colorselector">
                            <span></span>
                        </span>
                    </div>


                </div>
                <div class="col-sm-6">

                    <div class="form-group">
                        <label class="control-label">Secondary Color</label><br />
                        <input type="text" name="secondary_color" class="form-control colorpicker-input" id="colorpicker2" value="<?php echo $setting['app_secondary_color'] ?>">
                        <span id="colorSelector2" class="colorselector">
                            <span></span>
                        </span>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label>
                        <div>Contact Name <span class="field_required">*</span></div>
                    </label>
                    <input type="text" name="contact_name" placeholder="Contact Name " class="form-control" value="<?php echo $setting['app_contact_name'] ?>">
                    <span class="error" id="contact_name_err"></span>
                </div>
                <div class="col-sm-6">
                    <label>
                        <div>Contact Email <span class="field_required">*</span></div>
                    </label>
                    <input type="text" name="contact_email" placeholder="Contact Email" class="form-control" value="<?php echo $setting['app_contact_email'] ?>">
                    <span class="error" id="contact_email_err"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <label>
                    <div>Contact No <span class="field_required">*</span></div>
                </label>
                <input type="text" name="contact_no" placeholder="Contact Email" class="form-control" value="<?php echo $setting['app_contact_no'] ?>">
                <span class="error" id="contact_no_err"></span>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label>
                        <div>Address </div>
                    </label>
                    <input type="text" name="address" placeholder="Address (Detailed Address) " class="form-control" value="<?php echo $setting['app_address'] ?>">
                    <span class="error" id="address_err"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <label>
                        <div>Welcome Message </div>
                    </label>
                    <input type="text" name="welcome_message" placeholder="Welcome Message " class="form-control" value="<?php echo $setting['app_wecome_message'] ?>">
                    <span class="error" id="welcome_message_err"></span>
                </div>
            </div>
            <div class="form-group">
                <h3 class="col-sm-12">Upload App Logo</h3>
                <span class="help-block col-sm-12">Uploads must be PNG </span> 
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                  <!--<div class="fileinput fileinput-new" data-provides="fileinput"> <a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                    <div class="fileinput-preview thumbnail event_logo_image" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;"><img src="http://placehold.it/106x64" alt=""></div>
                    <div class=""><span class="btn btn-default btn-file"><span class="fileinput-new">App Logo*<br>
                      (180px x 180px)</span><span class="fileinput-exists">Change Logo</span>
                      <input type="file"  class="form-control" placeholder="Logo" pickfiles>
                      </span></div>
                    
                    
                  </div>-->
                    <div id="logo_display_thumb_image">
                        <?php
                        if (file_exists(UPLOADS . 'app_logo/' . $setting['app_logo_big']))
                            echo '<img src="' . SITE_URL . 'uploads/app_logo/' . $setting['app_logo_big'] . '" height="100" width="100"/>';
                        ?>
                        <input type="hidden" name="app_logo_image" id="app_logo_image" value="<?php echo $setting['app_logo_big']; ?>">
                    </div>
                    <div id="logo_filelist" ></div>
                    <div id="logo_container">
                        <input type="file" style="margin-top:20px;"   id="logo_pickfiles" >
                        <label style="margin:5px 0 0 0">Select Image</label>
                        <span class="error" id="app_logo_image_err"></span>

                    </div>
                </div>
            </div>
            <div class="form-group">
                <h3 class="col-sm-12">Upload App background Image</h3>
                <span class="help-block col-sm-12">Uploads must be PNG </span> 
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                  <!--<div class="fileinput fileinput-new" data-provides="fileinput"> <a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                    <div class="fileinput-preview thumbnail event_logo_image" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;"><img src="http://placehold.it/106x64" alt=""></div>
                    <div class=""><span class="btn btn-default btn-file"><span class="fileinput-new">App Logo*<br>
                      (180px x 180px)</span><span class="fileinput-exists">Change background image</span>
                      <input type="file"  class="form-control" placeholder="Logo">
                      </span></div>
                  </div>-->
                    <div id="background_display_thumb_image">
                        <?php
                        if (file_exists(UPLOADS . 'app_background/' . $setting['app_background_image']))
                            echo '<img src="' . SITE_URL . 'uploads/app_background/' . $setting['app_background_image'] . '" height="100" width="100"/>';
                        ?>
                        <input type="hidden" name="app_background_image" id="app_background_image" value="<?php echo $setting['app_background_image'] ?>">
                    </div>
                    <div id="background_filelist" ></div>
                    <div id="background_container">
                        <input type="file" style="margin-top:20px;"   id="background_pickfiles" >
                        <label style="margin:5px 0 0 0">Select Image</label>
                        <span class="error" id="app_background_image_err"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <h3 class="col-sm-12">Upload Slider Images</h3>
                <span class="help-block col-sm-12">Uploads must be  JPG or PNG and smaller than 1MB</span> 
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                  <!--<div class="fileinput fileinput-new" data-provides="fileinput"> <a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                    <div class="fileinput-preview thumbnail event_logo_image" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;"><img src="http://placehold.it/106x64" alt=""></div>
                    <div class=""><span class="btn btn-default btn-file"><span class="fileinput-new">Event Logo*<br>
                      (180px x 180px)</span><span class="fileinput-exists">Change Logo</span>
                      <input type="file"  class="form-control" placeholder="Logo">
                      </span></div>
                  </div>-->
                    <div id="slider_filelist" style="display: inline-flex;">

                        <?php
                        $image = json_decode($setting['app_slider_image'], TRUE);
                        //display($image);
                        foreach ($image as $k => $v) {
                            if ($v) {
                                ?>
                                <div class=" " id="div_image_<?php echo $k ?>">
                                    <img src="<?php echo SITE_URL . 'uploads/app_slider/' . $v ?>" height="76" width="76" style="border:3px solid #fff; display:block;margin:0 10px">
                                    <a href="javascript:;" onclick="remove_image(this.id)" id="image_<?php echo $k ?>" style="margin:0 10px">Remove</a>
                                    <input type="hidden" name="app_slider_image[]" id="app_slider_image" value="<?php echo $v ?>">
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <!--<input type="hidden" name="app_slider_image[]" id="app_slider_image" value="">-->
                    <div id="slider_container" style="position:static !important;clear:both;">
                        <div class="clearfix1"></div>
                        <input type="file"    id="slider_pickfiles" >
                        <label>Select Image</label>
                        <span class="error" id="app_slider_image_err"></span>
                    </div>
                </div>


            </div>
            <div class="form-group">
                <div class="col-sm-4" >
                    <input type="button" class="btn btn-danger btn-block" value="Cancel">
                </div>
                <div class="col-sm-4">
                    <input name="submit" type="Submit"  value="Submit"  class="btn btn-success btn-block">
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function() {
            $("#slider_filelist").sortable();
            //$( "#slider_filelist" ).disableSelection();
        });



    </script>