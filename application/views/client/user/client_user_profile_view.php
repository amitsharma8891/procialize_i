
<?php $this->load->view(CLIENT_HEADER) ?>
<script src="<?php echo SITE_URL ?>public/client/jsvalidation/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo SITE_URL ?>public/client/jsvalidation/screen.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php
if (isset($user_data)) {
    if (isset($errors)) {
        $user_data = (object) $user_data;
    }
}
?>

<!----event top navigation---->
<?php //$this->load->view(EVENT_TOP_NAVIGATION)    ?>
<!----event top navigation---->

<div class="contentpanel">
    <div class="panel panel-default panel-stat">
        <div class="panel-heading  panel-heading-alt">
            <div class="row" id="top121">
                <div class="col-xs-12">
                    <h3 class="text-center mb20" style="color:#58595b">
                        <?php
                        if ($this->session->userdata('client_attendee_id'))
                            echo 'Edit Your Profile';
                        else
                            echo 'Sign Up';
                        ?>

                    </h3>
                    <form role="form" action="<?php echo SITE_URL ?>client/user/save_user" id="user_form" method="POST" enctype="multipart/form-data" >
                        <div class="stat attnd">
                            <div class="row mb15">
                                <div class="col-xs-4 col-sm-4">

                                    <div class="thumb" id="display_thumb_image">
                                        <!--<img src="images/photos/loggeduser.png" alt="" class="img-responsive userlogo"/>-->
                                        <?php
                                        //$image_name =  $user_data->photo;
                                        //display($user_data);
                                        $image = '';
//                                        echo $user_data->photo;
                                        if (isset($user_data->photo)) {
                                            $image = $user_data->photo;
                                            echo '<img src="' . SITE_URL . 'uploads/' . front_image('attendee', $user_data->photo) . '" alt="" class="img-responsive userlogo"/>'
                                            . '<input type="hidden" name="profile_pic" id="profile_pic" value="' . $user_data->photo . '">';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8">
                                    <div class="form-group">
                                        <div id="filelist" ></div>
                                        <div id="container">
                                            <input type="file" style="margin-top:20px;" name="userimage"  id="pickfiles" >
                                            <label style="margin:5px 0 0 0">Select Image</label>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- row -->


                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="stat">

                                        <?php if (!$this->session->userdata('client_user_id')) { ?>   
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" placeholder="Email*" value="<?php echo isset($user_data->email) ? $user_data->email : '' ?>"  validate = 'required|trim|is_unique[user.email]' class="form-control"required />
                                                <?php echo isset($errors['email_err']) && $errors['email_err'] ? '<label for="email" class="error" id="email_err" >' . $errors['email_err'] . '</label>' : '' ?>
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="password" id="password" placeholder="Password*" validate="trim|required|matches[conf_password]" value="" class="form-control" required />
                                                <label for="password" class="error" id="password_err" style="display:none;">This field is required.</label>
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="conf_password" id="conf_password" placeholder="Confirm Password*" value="" validate = "trim|required" class="form-control" required/>
                                                <label for="conf_password" class="error" id="conf_password_err" style="display:none;">This field is required.</label>
                                            </div>
                                        <?php } ?>

                                        <div class="form-group">
                                            <input type="text" name="first_name" id="first_name"  placeholder="First Name*"  value="<?php echo isset($user_data->first_name) ? $user_data->first_name : '' ?>" class="form-control validate[required]" required  />
                                            <?php echo isset($errors['first_name_err']) && $errors['first_name_err'] ? '<label for="fname" class="error" id="first_name_err" >' . $errors['first_name_err'] . '</label>' : '' ?>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="last_name" id="last_name" placeholder="Last Name*" value="<?php echo isset($user_data->last_name) ? $user_data->last_name : '' ?>" class="form-control validate[required]" required/>
                                            <label for="lname" class="error" id="last_name_err" style="display:none;">This field is required.</label>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="designation" id="designation" placeholder="Designation*" value="<?php echo isset($user_data->designation) ? $user_data->designation : '' ?>" class="form-control validate[required]" required/>
                                            <label for="designation" class="error" id="designation_err" style="display:none;">This field is required.</label>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="company" id="company" placeholder="Company Name*" value="<?php echo isset($user_data->company_name) ? $user_data->company_name : '' ?>" class="form-control validate[required]" required />
                                            <label for="company" class="error" id="company_err" style="display:none;">This field is required.</label>
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control" name="description" id="description"  rows="3" placeholder="Description"><?php echo isset($user_data->description) ? $user_data->description : '' ?></textarea>
                                            <label for="description" class="error" style="display:none;">This field is required.</label>
                                        </div>


                                        <div class="form-group mt15">
                                            <select name="industry_id[]" id="industry_id" class="form-control chosen-select validate[required]" data-placeholder="Add a Industry*" required>
                                                <option value="">Add Industry*</option>

                                                <?php
                                                if ($industry_list) {
                                                    foreach ($industry_list as $industry) {
                                                        $selected = '';
                                                        if (isset($user_data->industry_id)) {
                                                            $temp_func = explode(',', $user_data->industry_id);
                                                            foreach ($temp_func as $key1 => $db_industry) {
                                                                if ($db_industry == $industry['name']) {
                                                                    $selected = 'selected';
                                                                }
                                                            }
                                                        }
                                                        echo '<option ' . $selected . ' value="' . $industry['name'] . '">' . $industry['name'] . '</option>';
                                                    }
                                                }
                                                ?>                   
                                            </select>
                                            <label for="industry_id" class="error" id="industry_id_err" style="display:none;">This field is required.</label>
                                        </div>


                                        <div class="form-group">
                                            <select name="functionality_id[]" id="functionality_id"  class="form-control chosen-select validate[required]" placeholder="Add Functionality*" data-placeholder="Add Functionality*" required>

                                                <?php
                                                if ($functionality_list) {

                                                    foreach ($functionality_list as $func) {
                                                        $selected = '';
                                                        if (isset($user_data->functionality_id)) {
                                                            $temp_func = explode(',', $user_data->functionality_id);
                                                            foreach ($temp_func as $key => $db_funct) {
                                                                if ($db_funct == $func['name']) {
                                                                    $selected = 'selected';
                                                                }
                                                            }
                                                        }
                                                        echo '<option ' . $selected . ' value="' . $func['name'] . '">' . $func['name'] . '</option>';
                                                    }
                                                }
                                                ?>  


                                            </select>
                                            <label for="functionality_id" class="error" id="functionality_id_err" style="display:none;">This field is required.</label>
                                        </div>


                                        <div class="form-group">
                                            <input type="text" name="website" id="website" placeholder="Website" value="<?php echo isset($user_data->website) ? $user_data->website : '' ?>" class="form-control" />
                                            <label for="mobile" class="error" style="display:none;">This field is required.</label>
                                        </div>

                                        <div class="form-group" >
                                            <select type="select" name="country" id="country" class="form-control chosen-select"> 
                                                <option value = "0">Select Country</option>
                                                <?php
                                                $seletcted = "";
                                                foreach ($country_list as $key => $value) {

                                                    if (isset($user_data->country)) {
                                                        if ($user_data->country == $value['id']) {

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
                                            <label for="country" class="error" style="display:none;">This field is required.</label>
                                        </div>
                                        <div class="form-group" >
                                            <select type="select" name="city" id="city" class="form-control chosen-select"> 
                                                <option value = "0">Select city</option>
                                                <?php
                                                $seletcted = "";
                                                foreach ($city_list as $key => $value) {

                                                    if (isset($user_data->city)) {
                                                        if ($user_data->city == $value['id']) {

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
                                            <label for="city" class="error" style="display:none;">This field is required.</label>
                                        </div>
                                        <!--                                        <div class="form-group">
                                                                                    <input type="text" name="country" id="country" placeholder="Country" value="<?php echo isset($user_data->country) ? $user_data->country : '' ?>" class="form-control" />
                                                                                    <label for="country" class="error" style="display:none;">This field is required.</label>
                                                                                </div>
                                        
                                                                                <div class="form-group">
                                                                                    <input type="text" name="city" id="city" placeholder="City*" value="<?php echo isset($user_data->city) ? $user_data->city : '' ?>" class="form-control validate[required]" required />
                                                                                    <label for="city" class="error" id="city_err" style="display:none;">This field is required.</label>
                                                                                </div>-->




                                        <div class="form-group">
                                            <input type="text" name="mobile" id="mobile" placeholder="Mobile No" value="<?php echo isset($user_data->mobile) ? $user_data->mobile : '' ?>" class="form-control" />
                                            <label for="mobile" class="error" id="mobile_err" style="display:none;">This field is required.</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="phone" id="phone" placeholder="Phone No" value="<?php echo isset($user_data->phone) ? $user_data->phone : '' ?>" class="form-control" />
                                            <label for="mobile" class="error" id="phone_err" style="display:none;">This field is required.</label>
                                        </div>

                                        <div class="checkbox-inline mb10">

                                            <?php
                                            $checked = '';
                                            if (isset($user_data->subscribe_email)) {
                                                if ($user_data->subscribe_email == 1)
                                                    $checked = '';
                                                else
                                                    $checked = 'checked';
                                            }
                                            ?>
                                            <label> <input type="checkbox" <?php echo $checked ?> name="sbscribe_email" id="sbscribe_email">Don't Send Email Notifications</label>
                                        </div>


                                        <?php
                                        if (isset($user_data->password) && $user_data->password != '') {
                                            ?>   
                                            <h3 class="text-center mb20" style="color:#58595b">Change Password</h3>
                                            <div class="form-group">
                                                <input type="password" name="current_password" id="current_password" placeholder="Current Password" value="" class="form-control" />
                                                <label for="mobile" class="error" id="current_password_err" style="display:none;">This field is required.</label>
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="password" id="password" placeholder="New Password" value="" class="form-control" />
                                                <label for="mobile" class="error" id="password_err" style="display:none;">This field is required.</label>
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="conf_password" id="conf_password" placeholder="Re-type New Password" value="" class="form-control" />
                                                <label for="mobile" class="error" id="conf_password_err" style="display:none;">This field is required.</label>
                                            </div>
                                        <?php } ?>

                                        <!--                        <div class="form-group">
                                                                <input type="text" value="022-25162983" class="form-control" />
                                                                <label for="phone" class="error" style="display:none;">This field is required.</label>
                                                                </div>-->

                                        <div class="form-group">
                                            <input type="hidden" name="type_of_attendee" id="type_of_attendee" value="<?php echo isset($user_data->attendee_type) ? $user_data->attendee_type : 'A' ?>">
                                            <div class="save_loader text-center" style="width: 100%"></div><button id="save_user_btn" class="btn btn-success btn-block center-block mb10" type="submit" >Save</button>
                                        </div>


                                    </div>
                                    <!-- stat -->
                                </div><!-- col-sm-6 -->

                            </div>

                        </div><!-- stat -->
                    </form>	  
                </div><!-- col-sm-6 -->

            </div><!-- row -->
        </div>
    </div>
</div><!-- contentpanel -->

</div><!-- mainpanel -->

<div class="rightpanel">

    <!--Right panel view--->
    <?php $this->load->view(CLIENT_RIGHT_PANEL) ?>
    <!--Right panel view--->

</div><!-- rightpanel -->


</section>

<?php
$usr_id = $this->session->userdata('client_user_id');
?>
<script type = "text/javascript">
            $().ready(function() {

    jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
            $("#user_form").validate({
    rules: {
    first_name: "required",
            last_name: "required",
            designation: "required",
            company: "required",
            city: "required",
            //description: "required",
            functionality_id: "required",
            industry_id: "required",
<?php if (!$usr_id) { ?>
        password: {
        required: true,
                //					minlength: 5
        },
                conf_password: {
                required: true,
                        //					minlength: 5,
                        equalTo: "#password"
                },
<?php } ?>
    //				agree: "required"
    },
            messages: {
            firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    designation: "Please enter your Designation",
                    company: "Please enter your Company",
                    City: "Please enter your City",
                    //description: "Please enter your description",
                    functionality_id: "Please Select your functionality",
                    industry_id: "Please Select your industry",
<?php if (!$usr_id) { ?>
                password: {
                required: "Please provide a password",
                },
                        conf_password: {
                        required: "Please provide a password",
                                equalTo: "Please enter the same password as above"
                        },
                        //                        email: "Please enter a valid email address",
<?php } ?>
            //				agree: "Please accept our policy"
            },
            submitHandler: function(form) {
            var functionality = $("#functionality_id").val();
                    var industry = $("#industry_id").val();
                    industry = $.trim(industry)
                    functionality = $.trim(functionality)
                    if (functionality == null || functionality == ""){
            $("#functionality_id_err").html('Please Select your functionality');
                    $("#functionality_id_err").show();
                    return false;
            } else{
            $("#functionality_id_err").hide();
            }
            if (industry == "" || industry == null || industry == 'undefined'){
            $("#industry_id_err").html('Please Select your industry');
                    $("#industry_id_err").show();
                    return false;
            } else{
            $("#industry_id_err").hide();
            }
            form.submit();
            }

    });
            $('#country').change(function() {
    var SITE_URL = '<?php echo SITE_URL; ?>';
            var html_val = new Array();
            var country_id = $(this).val();
            $.ajax({
            type                                                            : "POST",
                    url                                                             : SITE_URL + "manage/place/get_city",
                    dataType                                                        : "json",
                    data                                                            : {
                    'country_id':country_id,
                    },
                    success : function(res)
                    {
                    $.each(res.city_list, function(index, value) {
                    var temp = '<option value = "' + value.name + '" >' + value.name + '</option>';
                            html_val.push(temp);
                    });
                            $('#city').find('option').remove().end();
                            $('#city').append(html_val);
                            $("#city").trigger("chosen:updated");
                            console.clear();
                    }
            });
    });
    });
</script>

<?php $this->load->view(CLIENT_FOOTER) ?>
