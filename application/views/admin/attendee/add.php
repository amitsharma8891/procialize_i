<div class="contentpanel"> Content Panel 
    <div class="row mb10"> Add Exhibitor Row 
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <?php echo validation_errors('<div class="form-validation-error">', '</div>'); ?>
        <?php echo generateFormHtml($fields); ?>
    </div>
</div>

<script>
    $('document').ready(function() {
        $('#country').change(function() {
            var SITE_URL = '<?php echo SITE_URL; ?>';
            var html_val = new Array();
            var country_id = $(this).val();
            $.ajax({
                type: "POST",
                url: SITE_URL + "manage/place/get_city",
                dataType: "json",
                data: {
                    'country_id': country_id,
                },
                success: function(res)
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
<!--

<div class="contentpanel"> Content Panel 
    <div class="row mb10"> Add Exhibitor Row 
<?php
//if (isset($error)) {
//    echo $error;
//}
?>
<?php // echo validation_errors('<div class="form-validation-error">', '</div>'); ?>
<?php // echo generateFormHtml($fields); ?>
<?php
$superadmin = $this->session->userdata('is_superadmin');
$arrResult = array();
if (!is_null($id)) {
//            echo "dfgdfgfd";die;
//            $arrResult = $this->getAll($id, TRUE);
    //echo '<pre>'; print_r($arrResult); exit;
    $this->object = $arrResult;
    if (array_key_exists('photo', $arrResult)) {
        if ($arrResult->photo == '') {
            unset($arrResult->photo);
        }
    }
}

//echo '<pre>'; print_r($_COOKIE); exit;  
if (array_key_exists('postarray', $_COOKIE)) {
    if (!empty($_COOKIE['postarray'])) {
        $cookie = $_COOKIE['postarray'];
        $cookie = stripslashes($cookie);
        $postarray = json_decode($cookie, true);
        //echo '<pre>'; print_r($postarray); exit; 
    }
} else {
    $postarray = array();
}
//          echo '<pre>';print_r($postarray);exit;
if ($superadmin)
    $this->event_id = isset($arrResult->event_id) ? $arrResult->event_id : '';


if (isset($arrResult->photo)) {
    $up_photo = '<img src="' . base_url() . UPLOAD_ATTENDEE_PHOTO_DISPLAY . $arrResult->photo . '" alt="photo">';
} else {
    $up_photo = '<img src="http://placehold.it/106x64" alt="photo">';
}
//        display($arrResult);
//        die;
?>

        <input type="hidden" name="event_id" value="<?php isset($this->event_id) ? $this->event_id : ''; ?>"/> 
<?php if ($superadmin) { ?>
                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="col-sm-1 control-label form-label-placeholder"><div>Events </div></label>
                        <input type="dropdown" name="event_id" id="event_id"  options= "<?php $event_model_drop_dwn ?>"  class="form-control chosen-select"  validate='required' data-placeholder="Select Events"  placeholder= "First Name*"  error='Event' value="<?php set_value('event_id', (($this->event_id != '') ? $this->event_id : (isset($postarray['event_id']) ? $postarray['event_id'] : ''))) ?>"/>
                    </div>

                </div>
<?php } ?>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>First Name<span class="field_required">*</span></div></label>
                <input type="text" name="first_name" id="first_name" class="form-control  validate[required]"  validate='required' placeholder= "First Name*"  error='First Name' value="<?php set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : (isset($postarray['first_name']) ? $postarray['first_name'] : ''))) ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Last Name </div></label>
                <input type="text" name="last_name" id="last_name" class="form-control"  validate='' placeholder= "Last Name"  error='Last Name' value="<?php set_value('last_name', ((isset($arrResult->last_name)) && ($arrResult->last_name != '') ? $arrResult->last_name : (isset($postarray['last_name']) ? $postarray['last_name'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Company Name</div></label>
                <input type="text" name="company_name" id="company_name" class="form-control"  validate='' placeholder= "Company Name"  error='Company Name' value="<?php set_value('company_name', ((isset($arrResult->company_name)) && ($arrResult->company_name != '') ? $arrResult->company_name : (isset($postarray['company_name']) ? $postarray['company_name'] : ''))) ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Designation </div></label>
                <input type="text" name="designation" id="designation" class="form-control"  validate='' placeholder= "Designation"  error='Designation' value="<?php set_value('designation', (isset($arrResult->designation) && ($arrResult->designation != '') ? $arrResult->designation : (isset($postarray['designation']) ? $postarray['designation'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Description</div></label>
                <input type="textarea" name="description" id="description" maxlength="200"  rows='5' class="form-control"  validate='' placeholder= "Description (Maximum 200 words)"  error='Description' value="<?php set_value('description', (isset($arrResult->description) && ($arrResult->description != '') ? $arrResult->description : (isset($postarray['description']) ? $postarray['description'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <h3 class="col-sm-12">Upload Information</h3>
            <span class="help-block col-sm-12">Uploads must be PDF/ DOC/ DOCX/ JPG/ or PNG and smaller than 3MB</span>
        </div>

        <div class="form-group">
            <div class="col-sm-1">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                    <div >
                                        <label class="col-sm-1 control-label form-label-placeholder"><div>Description</div></label>
                                        <input type="file" name="photo" id="photo"  class="form-control" 
                                               upload_config ="<?php
array(
    "upload_path" => UPLOAD_ATTENDEE_PHOTO,
    "allowed_types" => 'jpg|png|jpeg',
    "max_size" => '3072',
    "height" => '180',
    "width" => '180',
);
?>"
                                               validate='' placeholder= "photo"  error='Photo' />
                                    </div>
                                </div>

                <div data-provides="fileinput" class="fileinput fileinput-new">
                    <a data-dismiss="fileinput" class="closebtn fileinput-exists" title="remove" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                    <div style="max-width: 100%; max-height: 80px;" data-trigger="fileinput" class="fileinput-preview thumbnail">
<?php echo $up_photo; ?>
                    </div>
                    <div class="">
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new">
                                <i class="fa fa-picture-o"></i> Attendee Logo<br>(180px x 180px)
                            </span>
                            <span class="fileinput-exists">Change Logo</span>
                            <input type="file" error="Photo" validate="" placeholder="photo" class="form-control" id="photo" value="" name="photo">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h3 class="col-sm-12">General Information</h3>
            <input type="hidden" name="latitude" value="<?php set_value('latitude', (isset($arrResult->latitude) ? $arrResult->latitude : '')); ?>"/>
            <input type="hidden" name="longitude" value="<?php set_value('longitude', (isset($arrResult->longitude) ? $arrResult->longitude : '')); ?>"/>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Industry </div></label>
                <input type="dropdown" name="industry" id="industry_id" multiple class="form-control chosen-select"  data-placeholder="Select Industry" validate='' placeholder= "Industry"  error='Industry' options = "<?php $industry_model_drop_dwn ?>" value="<?php set_value('industry_id', (isset($arrResult->industry_id) ? explode(',', $arrResult->industry_id) : (isset($postarray['industry_id']) ? $postarray['industry_id'] : ''))); ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Functionality </div></label>
                <input type="dropdown" name="functionality" id="functionality_id" multiple data-placeholder="Select Functionality" class="form-control chosen-select"  validate='' placeholder= "Functionality"  error='Functionality'  options="<?php $functionality_model_drop_dwn; ?>" value="<?php set_value('functionality_id', (isset($arrResult->functionality_id) ? explode(',', $arrResult->functionality_id) : (isset($postarray['functionality_id']) ? $postarray['functionality_id'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Attendee Website Link</div></label>
                <input type="text" name="website" id="website" class="form-control"  validate='' placeholder= "Attendee Website Link"  error='Website Link' value="<?php set_value('website', (isset($arrResult->website) && ($arrResult->website != '') ? $arrResult->website : (isset($postarray['website']) ? $postarray['website'] : ''))) ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Attendee Facebook Link </div></label>
                <input type="text" name="facebook" id="facebook" class="form-control"  validate='' placeholder= "Attendee Facebook Link"  error='Facebook Link' value="<?php set_value('facebook', (isset($arrResult->facebook) && ($arrResult->facebook != '') ? $arrResult->facebook : (isset($postarray['facebook']) ? $postarray['facebook'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Attendee Linkedin Link</div></label>
                <input type="text" name="linkden" id="linkden" class="form-control"  validate='' placeholder= "Attendee Linkedin Link"  error='linkden Link' value="<?php set_value('linkden', (isset($arrResult->linkden) && ($arrResult->linkden != '') ? $arrResult->linkden : (isset($postarray['linkden']) ? $postarray['linkden'] : ''))) ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Contact Email ID<span class="field_required">*</span></div></label>
                <input type="text" name="email" id="email" class="form-control  validate[required]"  validate='required' placeholder= "Contact Email ID*"  error='Contact Email' value="<?php set_value('email', (isset($arrResult->email) ? $arrResult->email : (isset($postarray['email']) ? $postarray['email'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Attendee Country </div></label>

                <select name="country" id="country"   class="form-control chosen-select" data-placeholder="Select country" validate='' placeholder= "Country"  error='Country' value="<?php set_value('country', (isset($arrResult->country) ? explode(',', $arrResult->country) : (isset($postarray['country']) ? $postarray['country'] : ''))); ?>">
                                        <option value="">Select Event</option>>
<?php
if (!empty($place_model_drop_dwn)) {
    foreach ($place_model_drop_dwn as $country) {
        echo '<option value="' . $country . '">' . $country . '</option>';
    }
}
?>

                </select>



                <input type="dropdown" name="country" id="country"  class="form-control chosen-select"  data-placeholder="Select country" validate='' placeholder= "Country"  error='Country' options = "<?php // $place_model_drop_dwn      ?>" value="<?php // set_value('country', (isset($arrResult->country) ? explode(',', $arrResult->country) : (isset($postarray['country']) ? $postarray['country'] : '')));      ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Attendee City </div></label>

                <select name="city" id="city"   class="form-control chosen-select"  data-placeholder="Select City"  validate='' placeholder= "City"  error='City'   value="<?php set_value('city', (isset($arrResult->city) ? explode(',', $arrResult->city) : (isset($postarray['city']) ? $postarray['city'] : ''))); ?>">
                                        <option value="">Select Event</option>>
<?php
if (!empty($city_model_drop_dwn)) {
    foreach ($city_model_drop_dwn as $city) {
        echo '<option value="' . $city . '">' . $city . '</option>';
    }
}
?>

                </select>
                <input type="dropdown" name="city" id="city"  data-placeholder="Select City" class="form-control chosen-select"  validate='' placeholder= "City"  error='City'  options="<?php $city_model_drop_dwn; ?>" value="<?php set_value('city', (isset($arrResult->city) ? explode(',', $arrResult->city) : (isset($postarray['city']) ? $postarray['city'] : ''))) ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Phone Number<span class="field_required">*</span></div></label>
                <input type="text" name="phone" id="phone" class="form-control  validate[custom[phone]]"  validate='required' placeholder= "Phone Number"  error='Phone Number' value="<?php set_value('phone', (isset($arrResult->phone) && ($arrResult->phone != '') ? $arrResult->phone : (isset($postarray['phone']) ? $postarray['phone'] : ''))); ?>"/>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Mobile Number</div></label>
                <input type="text" name="mobile" id="mobile" class="form-control validate[custom[phone]]"  validate='' placeholder= "Mobile Number"  error='Mobile Number' value="<?php set_value('mobile', (isset($arrResult->mobile) && ($arrResult->mobile != '') ? $arrResult->mobile : (isset($postarray['mobile']) ? $postarray['mobile'] : ''))) ?>"/>
            </div>

        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label class="col-sm-1 control-label form-label-placeholder"><div>Status </div></label>
                <select name="status"  class='form-control chosen-select'  data-placeholder="Status"  value="<?php set_value('status', (isset($arrResult->status) && ($arrResult->status != '') ? $arrResult->status : (isset($postarray['status']) ? $postarray['status'] : ''))) ?>">
                    <option value="1">Status - Enabled</option>
                    <option value="0">Status - Disabled</option>
                </select>
                <input type="dropdown" name="status" id="form-status"  options='<?php $status_option ?>' data-placeholder="Status" class="form-control chosen-select"  validate='' placeholder= "Status"  value="<?php //set_value('status', (isset($arrResult->status) && ($arrResult->status != '') ? $arrResult->status : (isset($postarray['status']) ? $postarray['status'] : '')))             ?>"/>
            </div>
        </div>

    </div>
</div>-->