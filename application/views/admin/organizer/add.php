<!--//Cropic files start -->
<link href="<?php echo SITE_URL ?>public/admin/css/croppic.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Mrs+Sheppards&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script src="<?php echo SITE_URL ?>public/admin/js/croppic.min.js"></script>
<script src="<?php echo SITE_URL ?>public/admin/js/main.js"></script>
<!--//Cropic files end  -->




<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/admin_organizer_module.js"></script>
<!--<script type="text/javascript" src="<?php echo CLIENT_PLUGINS ?>plupload/plupload.full.js"></script>-->    
<!--<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/organizer_logo.js"></script>-->
<script>
    var SITE_URL = '<?php echo SITE_URL ?>';
</script>
<div class="contentpanel"><!-- Content Panel -->
    <div class="row mb10"><!-- Add Exhibitor Row -->
        <?php
        if (isset($error)) {
            //echo $error;
        }
        ?>
        <?php
//echo "<pre>";       print_r($this->session->userdata('is_superadmin'));
//echo  validation_errors();
        ?>
        <?php // print_r($list->name); ?>
         <!--<form onsubmit="return false" id="email_template_form"  action="<?php //echo SITE_URL                                                 ?>manage/organizer/add_edit">-->
        <form  onsubmit="return false" method="post" accept-charset="utf-8" id="form1" name="form1" role="form" enctype="multipart/form-data">
            <div  class='form-group'   >
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Organizer Name <span class="field_required">*</span> </div>
                    </lable>
                    <input type="text" name="name" id="name" value="<?php echo $list->name ?>" class="form-control" placeholder="Please Enter Organizer Name" validate="is_unique[organizer.name]" error="Name"  />
                    <span id="name_err" style="color: red"></span>
                </div>
            </div>
            <?php
            if ($this->session->userdata('is_superadmin')) {
                ?>
                <div  class='form-group'>
                    <div  class='col-sm-6'>
                        <lable  class='col-sm-1 control-label form-label-placeholder'   >
                            <div>Private App</div>
                        </lable>
                        <?php
                        $options = array(
                            1 => " Yes ",
                            0 => " No "
                        );
                        ?>
                        <select type="select" name="is_pvt_id" class="form-control chosen-select"> 

                            <?php
                            $seletcted = "";
                            foreach ($options as $key => $value) {

                                if (isset($list->is_pvt_id)) {
                                    if ($list->is_pvt_id == $key) {

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
            <?php } ?>
            <div  class='form-group'   >
                <h3 class="col-sm-12">Upload Information</h3>
                <span class="help-block col-sm-12">Uploads must be JPG/JPEG/PNG and recommended to be smaller than 3 MB.</span> </div>
            <!--cropic file start-->
            <div id="headerwrap">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 cropHeaderWrapper">
                            <div id="croppic"></div>
                            <span class="btn" id="cropContainerHeaderButton">Upload Organizer Logo (Crop the Logo as desired)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 optionsDiv" id="optionsFloating">
            </div>

            <!--cropic file end -->

            <div  class='form-group'  style="clear: both;float: left;" >
                <div  class='col-sm-1'>
                    <div id="logo_display_thumb_image">
                        <?php
                        if (file_exists('uploads/organizer/logo/' . $list->organiser_photo) && $list->organiser_photo)
                            echo '<img src="' . SITE_URL . 'uploads/organizer/logo/' . $list->organiser_photo . '" height="100" width="100"/>';
                        ?>
                        <input type="hidden" name="app_logo_image" id="app_logo_image" value="<?php //echo $setting['app_logo_big'];                                                ?>">
                    </div>
                    <div id="logo_filelist" ></div>
                </div>
                <div  class='col-sm-1'   ></div>
            </div>
            <div  class='form-group'   >
                <h3 class="col-sm-12">Login Details</h3>
            </div>
            <div  class='form-group'   >
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>First Name <span class="field_required">*</span></div>
                    </lable>
                    <input type="text" name="first_name" value="<?php echo $list->first_name ?>" id="first_name" class="form-control " placeholder="Please Enter Organizer's First Name" validate="required" error="First Name"  />
                    <span id="first_name_err" style="color: red"></span>

                </div>
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Last Name</div>
                    </lable>
                    <input type="text" name="last_name" value="<?php echo $list->last_name ?>" id="last_name" class="form-control " placeholder="Please Enter Organizer's Last Name" validate="" error="Last Name"  />
                </div>
            </div>
            <div  class='form-group'   >
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Username <span class="field_required">*</span></div>
                    </lable>
                    <input type="text" name="username" value="<?php echo $list->username ?>" id="username" class="form-control " placeholder="Choose a username that contains only letters & numbers" validate="required" error="Username"  />
                    <span id="username_err" style="color: red"></span>

                </div>
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Email-ID <span class="field_required">*</span> </div>
                    </lable>
                    <?php
                    if (isset($list->user_id) && !empty($list->user_id)) {
                        $readonly = 'readonly';
                    } else {
                        $readonly = "";
                    }
                    ?>
                    <input type="text" name="email" <?php echo $readonly; ?> value="<?php echo $list->email ?>" id="email" class="form-control" placeholder="What's your email address? " validate="required|is_unique[user.email]" error="Email"  />
                    <span id="email_err" style="color: red"></span>

                </div>
            </div>
            <?php
            $is_super_admin = $list->is_superadmin;
            $is_superadmin = $this->session->userdata('is_superadmin');
            if (!$this->session->userdata('is_superadmin') || $is_super_admin) {
                ?>
                <div  class='form-group'>
                    <div  class='col-sm-6'>
                        <lable  class='col-sm-1 control-label form-label-placeholder'   >
                            <div>Current Password <span class="field_required">*</span></div>
                        </lable>
                        <input type="password" name="current_password" value="" id="current_password" class="form-control" placeholder="Enter Current Password." validate="required" error="Password"  />
                        <span id="current_password_err" style="color: red"></span>

                    </div>
                    <?php
                }
                if ($this->session->userdata('is_superadmin')) {
                    ?>
                    <div  class='form-group'   >
                    <?php } ?>
                    <div  class='col-sm-6'   >
                        <lable  class='col-sm-1 control-label form-label-placeholder'   >
                            <div>Password <span class="field_required">*</span></div>
                        </lable>
                        <input type="password" name="password" value="" id="password" class="form-control" placeholder="Enter Password." validate="required" error="Password"  />
                        <span id="password_err" style="color: red"></span>

                    </div>
                    <?php
                    if (!$this->session->userdata('is_superadmin') || $is_super_admin) {
                        ?>
                    </div>
                    <div  class='form-group'>
                    <?php } ?>
                    <div  class='col-sm-6'   >
                        <lable  class='col-sm-1 control-label form-label-placeholder'   >
                            <div>Confirm Password <span class="field_required">*</span> </div>
                        </lable>
                        <input type="password" name="cpassword" value="" id="cpassword" class="form-control " placeholder="Confirm Password" validate="required|matches[password]" error="Confirm Password"  />
                        <span id="passconf_err" style="color: red"></span>

                    </div>
                    <?php
                    if ($this->session->userdata('is_superadmin')) {
                        ?>
                    </div>
                    <div  class='form-group'   >

                    <?php } ?>
                    <div  class='col-sm-6'>
                        <lable  class='col-sm-1 control-label form-label-placeholder'   >
                            <div>Status</div>
                        </lable>
                        <select name="status"  class='form-control chosen-select'    data-placeholder="Status" >
                            <option value="1">Status - Enabled</option>
                            <option value="0">Status - Disabled</option>
                        </select>
                    </div>


                    <?php
                    if (!$this->session->userdata('is_superadmin') || $is_super_admin) {
                        ?>
                    </div>

                <?php } ?>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $list->user_id ?>">
            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-sm-4" id="cancel_button">
                    <input type="button" class="btn btn-danger btn-block" value="Cancel" />
                </div>
                <div class="col-sm-4">
                    <button name="btnSave" type="Submit" value="1" id="btnSave" class="btn btn-success btn-block" >Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var croppicHeaderOptions = {
        uploadUrl: '<?php echo SITE_URL ?>manage/organizer/img_save_to_file',
        cropData: {
            "dummyData": 1,
            "dummyData2": "asdas"
        },
        cropUrl: '<?php echo SITE_URL ?>manage/organizer/img_crop_to_file',
        customUploadButtonId: 'cropContainerHeaderButton',
        modal: true,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function() {
            console.log('onBeforeImgUpload')
        },
        onAfterImgUpload: function() {
            console.log('onAfterImgUpload')
            $("#app_logo_image").val(response.upload_image_name);
        },
        onImgDrag: function() {
            console.log('onImgDrag')
        },
        onImgZoom: function() {
            console.log('onImgZoom')
        },
        onBeforeImgCrop: function() {
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function() {
            console.log('onAfterImgCrop');
            $("#app_logo_image").val(response.crop_image_name);
        }
    }
    var croppic = new Croppic('croppic', croppicHeaderOptions);


    var croppicContainerModalOptions = {
        uploadUrl: '<?php echo SITE_URL ?>manage/organizer/img_save_to_file',
        cropUrl: '<?php echo SITE_URL ?>manage/organizer/img_crop_to_file',
        modal: true,
        imgEyecandyOpacity: 0.4,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);


    var croppicContaineroutputOptions = {
        uploadUrl: '<?php echo SITE_URL ?>manage/organizer/img_save_to_file',
        cropUrl: '<?php echo SITE_URL ?>manage/organizer/img_crop_to_file',
        outputUrlId: 'cropOutput',
        modal: false,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

    var croppicContainerEyecandyOptions = {
        uploadUrl: '<?php echo SITE_URL ?>manage/organizer/img_save_to_file',
        cropUrl: '<?php echo SITE_URL ?>manage/organizer/img_crop_to_file',
        imgEyecandy: false,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);
</script>