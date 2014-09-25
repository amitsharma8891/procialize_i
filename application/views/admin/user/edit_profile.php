<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/admin_user_module.js"></script>
<script type="text/javascript" src="<?php echo CLIENT_PLUGINS ?>plupload/plupload.full.js"></script>    
<script type="text/javascript" src="<?php echo SITE_URL ?>public/admin/js/module/organizer_logo.js"></script>
<script>
    var SITE_URL = '<?php echo SITE_URL ?>';
    var email = '<?php echo $list->email ?>';
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
        <?php // print_r($list->name);  ?>
         <!--<form onsubmit="return false" id="email_template_form"  action="<?php //echo SITE_URL                                         ?>manage/organizer/add_edit">-->
        <form  onsubmit="return false" method="post" accept-charset="utf-8" id="form1" name="form1" role="form" enctype="multipart/form-data">

            <div  class='form-group'   >
                <h3 class="col-sm-12">Edit Profile</h3>
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
                    <lable  class='col-sm-1 control-label form-label-placeholder'>
                        <div>Email-ID <span class="field_required">*</span> </div>
                    </lable>
                    <input type="text" name="email" readonly value="<?php echo $list->email ?>" id="email" class="form-control" placeholder="What's your email address? " validate="required|is_unique[user.email]" error="Email"  />
                    <span id="email_err" style="color: red"></span>

                </div>
            </div>
            <?php
            $is_super_admin = $list->is_superadmin;
//            print_r($is_super_admin)
//            echo  $is_super_admin;die;
            $is_superadmin = $this->session->userdata('is_superadmin');
            ?>
            <div  class='form-group'>
                <div  class='col-sm-6'>
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Current Password <span class="field_required">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('manage/login/forgot_password'); ?>"><small>Forgot Your Password?</small></a></div>
                    </lable>
                    <input type="password" name="current_password" value="" id="current_password" class="form-control" placeholder="Enter Current Password." validate="required" error="Password"  />
                    <span id="current_password_err" style="color: red"></span>

                </div>
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Password <span class="field_required">*</span></div>
                    </lable>
                    <input type="password" name="password" value="" id="password" class="form-control" placeholder="Enter Password." validate="required" error="Password"  />
                    <span id="password_err" style="color: red"></span>

                </div>
            </div>
            <div  class='form-group'>
                <div  class='col-sm-6'   >
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Confirm Password <span class="field_required">*</span> </div>
                    </lable>
                    <input type="password" name="cpassword" value="" id="cpassword" class="form-control " placeholder="Confirm Password" validate="required|matches[password]" error="Confirm Password"  />
                    <span id="passconf_err" style="color: red"></span>

                </div>


                <div  class='col-sm-6'>
                    <lable  class='col-sm-1 control-label form-label-placeholder'   >
                        <div>Status</div>
                    </lable>
                    <select name="status"  class='form-control chosen-select'    data-placeholder="Status" >
                        <option value="1">Status - Enabled</option>
                        <option value="0">Status - Disabled</option>
                    </select>
                </div>
            </div>

    </div>
    <input type="hidden" name="user_id" value="<?php echo $list->id ?>">
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
