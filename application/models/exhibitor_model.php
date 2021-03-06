<?php

class exhibitor_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    public $object = NULL;
    public $event_id;
    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'exhibitor.id';
    public $fields = array(
        "id",
        "name",
        "is_featured",
        'stall_number',
        "mail_sent",
        "description",
        "status",
        "created_by",
        "created_date",
        "event_id",
        "user_id",
        "pvt_org_id",
        "contact_id",
    );

    function generate_fields($id = NULL) {
        $superadmin = $this->session->userdata('is_superadmin');
        $arrResult = array();
        if (!is_null($id)) {
            $arrResult = $this->getAll($id, TRUE);
            $this->object = $arrResult;
//            echo '<pre>';print_r($arrResult);exit;
            if ($arrResult->logo == '') {
                unset($arrResult->logo);
            }
            if ($arrResult->brochure == '') {
                unset($arrResult->brochure);
            }
            if ($arrResult->floor_plan == '') {
                unset($arrResult->floor_plan);
            }
            if ($arrResult->image1 == '') {
                unset($arrResult->image1);
            }
            if ($arrResult->image2 == '') {
                unset($arrResult->image2);
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


        if (isset($arrResult->logo)) {
            $logo = '<img src="' . base_url() . 'uploads/exhibitor/' . $arrResult->logo . '" alt="logo">';
        } else {
            $logo = '<img src="http://placehold.it/106x64" alt="">';
        }

        if (isset($arrResult->brochure)) {
            $brochure = '<img src="' . base_url() . 'uploads/exhibitor/brochure/' . $arrResult->brochure . '" alt="brochure">';
        } else {
            $brochure = '<img src="http://placehold.it/106x64" alt="brochure">';
        }


        if (isset($arrResult->floor_plan)) {
            $floar_plan = '<img src="' . base_url() . 'uploads/exhibitor/floorplan/' . $arrResult->floor_plan . '" alt="floar_plan">';
        } else {
            $floar_plan = '<img src="http://placehold.it/106x64" alt="floar_plan">';
        }


        if (isset($arrResult->image1)) {
            $image1 = '<img src="' . base_url() . 'uploads/exhibitor/' . $arrResult->image1 . '" alt="logo">';
        } else {
            $image1 = '<img src="http://placehold.it/106x64" alt="">';
        }


        if (isset($arrResult->image2)) {
            $image2 = '<img src="' . base_url() . 'uploads/exhibitor/' . $arrResult->image2 . '" alt="logo">';
        } else {
            $image2 = '<img src="http://placehold.it/106x64" alt="">';
        }
        //  echo '<pre>';print_r($arrResult);exit;
        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'event_id' => array(
                "type" => "hidden",
                "event_id" => isset($this->event_id) ? $this->event_id : '',
            ),
            'is_featured' => array(
                "name" => "is_featured",
                "type" => "dropdown",
                "id" => "is_featured",
                "class" => "form-control chosen-select validate[required]",
                "attributes" => '  data-placeholder="Featured" ',
                "placeholder" => "Featured",
                "options" => array("0" => "Non-Featured", "1" => "Featured"),
                "validate" => '',
                "error" => 'Functionality',
                "value" => set_value('is_featured', (isset($arrResult->is_featured) ? $arrResult->is_featured : (isset($postarray['is_featured']) ? $postarray['is_featured'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Featured</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control validate[required]",
                "placeholder" => "Exhibitor Name*",
                "validate" => 'required|trim',
                "error" => 'Exhibitor Name',
                "value" => set_value('name', (isset($arrResult->name) ? $arrResult->name : (isset($postarray['name']) ? $postarray['name'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Exhibitor Name <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),

            'username' => array("name" => "username",
                "type" => "text",
                "id" => "username",
                "class" => "form-control validate[required]",
                "placeholder" => "Username*",
                "validate" => 'required|is_unique[user.username]',
                "error" => 'Username',
                "value" => set_value('username', (isset($arrResult->username) ? $arrResult->username : (isset($postarray['username']) ? $postarray['username'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Username*</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'password' => array("name" => "password",
                "type" => "password",
                "id" => "password",
                "class" => "form-control validate[required]",
                "placeholder" => "Password*",
                "validate" => 'required',
                "error" => 'Password',
                "value" => set_value('username', (isset($arrResult->password) ? $arrResult->password : '')),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Password*</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            /* 'event_id' => array(
              "type" => "hidden",
              "event_id" => isset($this->event_id) ? $this->event_id : '',
              ), */
            'description' => array("name" => "description",
                "type" => "textarea",
                "maxlength" => "500",
                "id" => "description",
                "class" => "form-control ",
                "rows" => '5',
                "placeholder" => "Description",
                "validate" => '',
                "error" => 'Description',
                "value" => set_value('description', (isset($arrResult->description) ? $arrResult->description : (isset($postarray['description']) ? $postarray['description'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-12"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Description</div>',
                        "position" => "prependElement",
                    ),
//                    array(
//                        "tag" => "span",
//                        "close" => "true",
//                        "class" => "help-block",
//                        "content" => "Images must be JPG, GIF, or PNG and smaller than 2MB",
//                        "position" => "appendElement",
//                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">General Information</h3>
                            <span class="col-sm-12 help-block">Create a complete profile and get more customers to avail your Products and services. </span>
                            ',
                        "position" => "appendOuter",
                    ),
                ),
            ),
            'latitude' => array(
                "type" => "hidden",
                "latitude" => set_value('latitude', (isset($arrResult->latitude) ? $arrResult->latitude : $this->input->post('latitude'))),
            ),
            'longitude' => array(
                "type" => "hidden",
                "longitude" => set_value('longitude', (isset($arrResult->longitude) ? $arrResult->longitude : $this->input->post('longitude'))),
            ),
            'industry' => array("name" => "industry_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "attributes" => ' multiple data-placeholder="Select Industry"',
                "class" => "form-control chosen-select ",
                "placeholder" => "Industry",
                "validate" => '',
                "error" => 'Industry',
                "options" => $this->industry_model->getDropdownValues(),
                "value" => set_value('industry_id', (isset($arrResult->industry_id) ? explode(',', $arrResult->industry_id) : $this->input->post('industry_id'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Industry</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'functionality' => array("name" => "functionality_id[]",
                "type" => "dropdown",
                "id" => "functionality_id",
                "class" => "form-control chosen-select ",
                "attributes" => ' multiple data-placeholder="Select Functionality"',
                "placeholder" => "Functionality",
                "options" => $this->functionality_model->getDropdownValues(),
                "validate" => '',
                "error" => 'Functionality',
                "value" => set_value('functionality_id', (isset($arrResult->functionality_id) ? explode(',', $arrResult->functionality_id) : $this->input->post('functionality_id'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Functionality</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'website_link' => array("name" => "website_link",
                "type" => "text",
                "id" => "website_link",
                "class" => "form-control",
                "placeholder" => "Exhibitor Website Link",
                "validate" => '',
                "error" => 'Website Link',
                "value" => set_value('website_link', (isset($arrResult->website_link) ? $arrResult->website_link : (isset($postarray['website_link']) ? $postarray['website_link'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Exhibitor Website Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'facebook_link' => array("name" => "facebook_link",
                "type" => "text",
                "id" => "facebook_link",
                "class" => "form-control ",
                "placeholder" => "Exhibitor Facebook Link",
                "validate" => '',
                "error" => 'Facebook Link',
                "value" => set_value('facebook_link', (isset($arrResult->facebook_link) ? $arrResult->facebook_link : (isset($postarray['facebook_link']) ? $postarray['facebook_link'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Exhibitor Facebook Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'linkedin_link' => array("name" => "linkedin_link",
                "type" => "text",
                "id" => "linkedin_link",
                "class" => "form-control ",
                "placeholder" => "Exhibitor Linkedin Link",
                "validate" => '',
                "error" => 'Linkedin Link',
                "value" => set_value('linkedin_link', (isset($arrResult->linkedin_link) ? $arrResult->linkedin_link : (isset($postarray['linkedin_link']) ? $postarray['linkedin_link'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Exhibitor Linkedin Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'product_category' => array("name" => "product_category_id[]",
                "type" => "dropdown",
                "id" => "product_category_id",
                "class" => "form-control chosen-select validate[required]",
                "placeholder" => 'Event Start Date<span class="field_required">*</span></div>',
                "options" => $this->product_category_model->getDropdownValues(),
                "validate" => 'required|trim',
                "error" => 'Product Category',
                "attributes" => ' multiple id="product_category_id"   data-placeholder="Select Product Category"',
                "value" => set_value('product_category_id', (isset($arrResult->product_category_id) ? explode(',', $arrResult->product_category_id) : (isset($postarray['product_category_id']) ? $postarray['product_category_id'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Select Product Category<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'country' => array("name" => "country",
                "type" => "dropdown",
                "id" => "country",
                "attributes" => 'id="country" data-placeholder="Select country"',
                "class" => "form-control chosen-select",
                "placeholder" => "country",
                "validate" => '',
                "error" => 'country',
                "options" => $this->place_model->getDropdownValues('country'),
                "value" => set_value('country', (isset($arrResult->country) ? explode(',', $arrResult->country) : (isset($postarray['country']) ? $postarray['country'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Attendee country</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'city' => array("name" => "city",
                "type" => "dropdown",
                "id" => "city",
                "attributes" => 'id="city" data-placeholder="Select city"',
                "class" => "form-control chosen-select",
                "placeholder" => "city",
                "validate" => '',
                "error" => 'city',
                "options" => $this->place_model->getDropdownValues('city', (isset($arrResult->country) ? $arrResult->country : ''), array('city.country_id')),
                "value" => set_value('city', (isset($arrResult->city) ? explode(',', $arrResult->city) : (isset($postarray['city']) ? $postarray['city'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Attendee City</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'stall_number' => array("name" => "stall_number",
                "type" => "text",
                "id" => "stall_number",
                "class" => "form-control  ",
                "placeholder" => "Stall Number",
                "validate" => '',
                "value" => set_value('location', (isset($arrResult->stall_number) ? $arrResult->stall_number : (isset($postarray['stall_number']) ? $postarray['stall_number'] : ''))),
                "error" => "stall number",
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-2"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Stall Number</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'logo' => array(
                "name" => "logo",
                "type" => "file",
                "id" => "logo",
                "class" => "form-control",
                "placeholder" => "Logo",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Logo',
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-2"
                    ),
                    array(
                        "tag" => "div",
                        "class" => "fileinput fileinput-new",
                        "close" => 'true',
                        "attribute" => 'data-provides="fileinput"',
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $logo . '</div>',
                    //'content'=> 
                    //"value" => set_value('location', (isset($arrResult->stall_number) ? $arrResult->stall_number : '')), '(isset($arrResult->logo) ? $arrResult->logo : "<img src='http://placehold.it/106x64' alt=''>" )'
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "",
                    ),
                    array(
                        "tag" => "span",
                        "close" => "true",
                        "class" => "btn btn-default btn-file",
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Exhibitor Logo<br>(180px x 180px)</span><span class="fileinput-exists">Change Logo</span>',
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">Upload Information</h3>
                                    <span class="help-block col-sm-12">Uploads must be PDF/ DOC/ DOCX/ JPG/ or PNG and smaller than 3MB</span>
                                    ',
                        "position" => "prependOuter",
                    ),
                ),
            ),
            'brochure' => array("name" => "brochure",
                "type" => "file",
                "id" => "brochure",
                "class" => "form-control",
                "placeholder" => "Brochure",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_BROCHURE,
                    "allowed_types" => 'jpg|png|jpeg|pdf|doc|docx',
                    "max_size" => '3072',
                ),
                "error" => 'Brochure',
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-2"
                    ),
                    array(
                        "tag" => "div",
                        "class" => "fileinput fileinput-new",
                        "close" => 'true',
                        "attribute" => 'data-provides="fileinput"',
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $brochure . '</div>'
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "",
                    ),
                    array(
                        "tag" => "span",
                        "close" => "true",
                        "class" => "btn btn-default btn-file",
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-cloud-upload"></i> Exhibitor Brochure</span><span class="fileinput-exists">Change Brochure</span>',
                    ),
                ),
            ),
        
            'image1' => array("name" => "image1",
                "type" => "file",
                "id" => "image1",
                "class" => "form-control",
                "validate" => '',
                "placeholder" => "Image1",
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => "Image1",
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3"
                    ),
                    array(
                        "tag" => "div",
                        "class" => "fileinput fileinput-new",
                        "close" => 'true',
                        "attribute" => 'data-provides="fileinput"',
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image1 . '</div>'
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "",
                    ),
                    array(
                        "tag" => "span",
                        "close" => "true",
                        "class" => "btn btn-default btn-file",
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Exhibitor Image 1<br>(180px x 180px)</span><span class="fileinput-exists">Change Image 1</span>',
                    ),
                ),
            ),
            'image2' => array("name" => "image2",
                "type" => "file",
                "id" => "image2",
                "class" => "form-control",
                "placeholder" => "Image2",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => "Image2",
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3"
                    ),
                    array(
                        "tag" => "div",
                        "class" => "fileinput fileinput-new",
                        "close" => 'true',
                        "attribute" => 'data-provides="fileinput"',
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image2 . '</div>'
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "",
                    ),
                    array(
                        "tag" => "span",
                        "close" => "true",
                        "class" => "btn btn-default btn-file",
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Exhibitor Image 2<br>(180px x 180px)</span><span class="fileinput-exists">Change Image 2</span>',
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close",
                        "class" => "",
                    ),
                ),
            ),
            // bhavana start
            'first_name' => array("name" => "contact_name",
                "type" => "text",
                "id" => "contact_name",
                "class" => "form-control",
                "placeholder" => "Contact Person's First Name",
                "validate" => '',
                "error" => 'Contact Person\'s Name',
                "value" => set_value('first_name', (isset($arrResult->contact_name) ? $arrResult->contact_name : (isset($postarray['contact_name']) ? $postarray['contact_name'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">Contact Details</h3>',
                        "position" => "prependOuter",
                    ),
                ),
            ),
            'last_name' => array("name" => "last_name",
                "type" => "text",
                "id" => "last_name",
                "class" => "form-control",
                "placeholder" => "Contact Person's Last Name",
                "validate" => '',
                "error" => 'Contact Person\'s Name',
                "value" => set_value('contact_name', (isset($arrResult->last_name) ? $arrResult->last_name : (isset($postarray['last_name']) ? $postarray['last_name'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        'tag' => 'div',
                        "close" => "close",
                    ),
                ),
            ),
            'phone' => array("name" => "contact_phone",
                "type" => "text",
                "id" => "mobile",
                "class" => "form-control validate[custom[phone]]",
                "placeholder" => "Phone Number",
                "validate" => 'regex_match[/^[\d\-\+\s]+$/]',
                "error" => 'Phone Number',
                "value" => set_value('phone', (isset($arrResult->contact_phone) ? $arrResult->contact_phone : (isset($postarray['contact_phone']) ? $postarray['contact_phone'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                ),
            ),
            'Telephone' => array("name" => "contact_telephone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control validate[custom[phone]]",
                "placeholder" => "Telephone Number",
                "validate" => 'regex_match[/^[\d\-\+\s]+$/]',
                "error" => 'Telephone Number',
                "value" => set_value('contact_telephone', (isset($arrResult->contact_mobile) ? $arrResult->contact_mobile : (isset($postarray['contact_telephone']) ? $postarray['contact_telephone'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        'tag' => 'div',
                        "close" => "close",
                    ),
                ),
            ),
            'email' => array("name" => "contact_email",
                "type" => "text",
                "id" => "contact_email",
                "class" => "form-control validate[required,custom[email]]",
                "placeholder" => "Contact Email*",
                "validate" => '',
                "error" => 'Contact Email',
                "value" => set_value('contact_email', (isset($arrResult->contact_email) ? $arrResult->contact_email : (isset($postarray['contact_email']) ? $postarray['contact_email'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                ),
            ),
            //bhavana end
            'status' => array(
                "name" => "status",
                "type" => "dropdown",
                "id" => "form-status",
                "class" => "form-control chosen-select",
                "attributes" => 'data-placeholder="Status" ',
                "placeholder" => "Status",
                "options" => array("1" => "Status - Enabled", "0" => "Status - Disabled"),
                "validate" => '',
                "error" => 'Status',
                "value" => set_value('status', (isset($arrResult->status) ? $arrResult->status : (isset($postarray['status']) ? $postarray['status'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-4"
                    )
                ),
            ),
        );

        if ($superadmin) {
            $arrData['fields']['event_id'] = array("name" => "event_id",
                "type" => "dropdown",
                "id" => "event_id",
                "class" => "form-control chosen-select",
                "attributes" => '  data-placeholder="Select Events" ',
                "placeholder" => "Events",
                "options" => $this->event_model->getDropdownValues(),
                "validate" => 'required',
                "error" => 'Event',
                "value" => set_value('event_id', isset($arrResult->event_id) ? $arrResult->event_id : ''),
                "decorators" => array(
                    array("tag" => "div",
                        "close" => "true",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Events </div>',
                        "position" => "prependElement",
                    ),
                ),
            );
        }
        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/exhibitor/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/exhibitor/add';
        }
        setcookie("postarray", "", time() - 3600);
        $arrData['fileUpload'] = TRUE;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves entire information of exhibitor
     * 
     * @author  Aatish Gore 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAll($data, $id = NULL) {
        $error = FALSE;
        if (!is_null($id))
            $arrResult = $this->getAll($id, TRUE);
        try {
            $this->db->trans_begin();

            if (is_null($id)) {
                # save exhibitor
                $data['type_of_user'] = 'E';
                $user_id = $this->user_model->save($data);
            } else {
//                echo '<pre>';print_r($data);exit;
                $user_id = $this->user_model->save($data, $arrResult->user_id);

                $data['user_id'] = $user_id = $arrResult->user_id;
            }
            #save contact person as attendee
            unset($data['username']);
            unset($data['password']);
            $data['email'] = $data['contact_email'];
            $data['first_name'] = $data['contact_name'];
//            $data['phone'] = $data['contact_phone'];
//            $data['mobile'] = $data['contact_telephone'];
//            $data['company_name'] = $data['name'];
//            $data['password'] = generatePassword(6);
            $data['type_of_user'] = 'A';
            if (is_null($id))
                array_filter($data);

            $contact_id = $this->user_model->save($data, (is_null($id)) ? NULL : $arrResult->contact_id);
            $data['contact_id'] = $contact_id;
            $data['user_id'] = $user_id;

            $exhibitor_id = $this->save($data, $id);
            $data['exhibitor_id'] = $exhibitor_id;
            $this->exhibitor_profile_model->save($data, $id);



            if (is_null($id)) {
                $data['spk_ex_id'] = $exhibitor_id;
                $data['spk_ex_type'] = 'exhibitor';
                $data['attendee_type'] = 'E';
                $data['user_id'] = $contact_id;
                $data['attendee_type'] = 'E';
                $data['phone'] = $data['contact_phone'];
                $data['mobile'] = $data['contact_telephone'];
                $data['company_name'] = $data['name'];
                $data['name'] = $data['contact_name'] . ' ' . $data['last_name'];
                $data['industry_id'] = $data['industry_id'];
                $data['functionality_id'] = $data['functionality_id'];
                unset($data['location']);
                unset($data['latitude']);
                unset($data['longitude']);
                unset($data['linkden']);
                unset($data['website']);
                unset($data['twitter']);
                unset($data['facebook']);
                unset($data['description']);
                $attendee_id = $this->attendee_model->save($data);

                $arrHasInsert = array();
                $arrHasInsert['event_id'] = $data['event_id'];
                $arrHasInsert['attendee_id'] = $attendee_id;
                $arrHasInsert['pvt_org_id'] = getPrivateOrgId();
                $arrHasInsert['status'] = 0;
                $arrHasInsert['passcode'] = generatePassword(6);

                $this->has_model->tableName = 'event_has_attendee';
                if (!is_null($id)) {
                    $arrHasDelete = array("attendee_id" => $arrResult->contact_id);
                    if (!$this->has_model->delete($arrHasDelete))
                        $error = TRUE;
                }
                $this->has_model->saveSingle($arrHasInsert);
            }else {
                $searchData['spk_ex_id'] = $exhibitor_id;
                $searchData['spk_ex_type'] = 'exhibitor';

                $attendee_id = $this->attendee_model->check_attendee($searchData);
            }

            #save tags
            if (!is_null($id)) {
                if (!$this->tag_relation_model->delete('exhibitor', $id))
                    $error = TRUE;

                if (!$this->tag_relation_model->delete('attendee', $attendee_id))
                    $error = TRUE;
            }
            if (isset($data['tag_name'])) {
                $tags = saveTags($data);
                $arrTagId = $this->tag_model->getTagByName($tags);
                $arrTags = array();
                $arrAttendeeTags = array();
                $i = 0;
                foreach ($arrTagId as $tag) {
                    $arrTags[$i]['object_id'] = $exhibitor_id;
                    $arrTags[$i]['object_type'] = 'exhibitor';
                    $arrTags[$i]['tag_id'] = $tag['id'];

                    $arrAttendeeTags[$i]['object_id'] = $attendee_id;
                    $arrAttendeeTags[$i]['object_type'] = 'attendee';
                    $arrAttendeeTags[$i]['tag_id'] = $tag['id'];
                    $i++;
                }

                $this->tag_relation_model->save_batch($arrTags);
                $this->tag_relation_model->save_batch($arrAttendeeTags);
            }


            $this->has_model->tableName = 'exhibitor_has_product_category';
            if (!is_null($id)) {
                $arrHasDelete = array("exhibitor_id" => $id);

                if (!$this->has_model->delete($arrHasDelete))
                    $error = TRUE;
            }

            if (isset($data['product_category_id'])) {
                $arrTags = array();
                foreach ($data['product_category_id'] as $industry) {
                    $arrTags[$i]['exhibitor_id'] = $exhibitor_id;
                    $arrTags[$i]['product_category_id'] = $industry;
                    $i++;
                }
                $this->has_model->save($arrTags);
            }


        } catch (Exception $e) {
            $error = true;
        }
        if ($error) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return true;
    }

    function saveAllOverwrite($data, $id = NULL) {
//C        echo '<pre>';print_r($data);exit;
        $error = FALSE;
        if (!is_null($id))
            $arrResult = $this->getAll($id, TRUE);
        try {
            $this->db->trans_begin();

            if (is_null($id)) {
                # save exhibitor
                $data['type_of_user'] = 'E';
                $user_id = $this->user_model->save($data);
            } else {
                if (count($arrResult) > 0) {
                    // $user_id = $this->user_model->save($data, $arrResult->user_id);
                    $data['user_id'] = $user_id = $arrResult->user_id;
                } else {
                    //  $user_id = $this->user_model->save($data);
                    $id = NULL;
                }
            }
            #save contact person as attendee
            unset($data['username']);
            unset($data['password']);
            $data['email'] = $data['contact_email'];
            $data['first_name'] = $data['contact_first_name'];
            $data['contact_name'] = $data['contact_first_name'];
            $data['last_name'] = $data['contact_last_name'];
            $data['phone'] = $data['contact_phone'];
            $data['mobile'] = $data['contact_mobile'];
            $data['company_name'] = $data['name'];
//            $data['password'] = generatePassword(6);
            $data['type_of_user'] = 'A';
            //echo '<pre>';print_r($data);exit;
            if (is_null($id))
                array_filter($data);
            $contact_id = $this->user_model->save($data, (is_null($id)) ? NULL : $arrResult->contact_id);
            $data['contact_id'] = $contact_id;
            $data['user_id'] = $user_id;

            $exhibitor_id = $this->save($data, $id);
            $data['exhibitor_id'] = $exhibitor_id;
            $this->exhibitor_profile_model->save($data, $id);



            if (is_null($id)) {
                $data['spk_ex_id'] = $exhibitor_id;
                $data['spk_ex_type'] = 'exhibitor';
                $data['attendee_type'] = 'E';
                $data['user_id'] = $contact_id;
                $data['attendee_type'] = 'E';
                $data['name'] = $data['contact_name'] . ' ' . $data['last_name'];
                unset($data['location']);
                unset($data['latitude']);
                unset($data['longitude']);
                unset($data['linkden']);
                unset($data['website']);
                unset($data['twitter']);
                unset($data['facebook']);
                unset($data['description']);
                $attendee_id = $this->attendee_model->save($data);

                $arrHasInsert = array();
                $arrHasInsert['event_id'] = $data['event_id'];
                $arrHasInsert['attendee_id'] = $attendee_id;
                $arrHasInsert['pvt_org_id'] = getPrivateOrgId();
                $arrHasInsert['status'] = 0;
                $arrHasInsert['passcode'] = generatePassword(6);

                $this->has_model->tableName = 'event_has_attendee';
                if (!is_null($id)) {
                    $arrHasDelete = array("attendee_id" => $arrResult->contact_id);
                    if (!$this->has_model->delete($arrHasDelete))
                        $error = TRUE;
                }
                $this->has_model->saveSingle($arrHasInsert);
            }else {
                $searchData['spk_ex_id'] = $exhibitor_id;
                $searchData['spk_ex_type'] = 'exhibitor';

                $attendee_id = $this->attendee_model->check_attendee($searchData);
            }

            #save tags
            if (!is_null($id)) {
                if (!$this->tag_relation_model->delete('exhibitor', $id))
                    $error = TRUE;

                if (!$this->tag_relation_model->delete('attendee', $attendee_id))
                    $error = TRUE;
            }
            if (isset($data['tag_name'])) {
                $tags = saveTags($data);
                $arrTagId = $this->tag_model->getTagByName($tags);
                $arrTags = array();
                $arrAttendeeTags = array();
                $i = 0;
                foreach ($arrTagId as $tag) {
                    $arrTags[$i]['object_id'] = $exhibitor_id;
                    $arrTags[$i]['object_type'] = 'exhibitor';
                    $arrTags[$i]['tag_id'] = $tag['id'];

                    $arrAttendeeTags[$i]['object_id'] = $attendee_id;
                    $arrAttendeeTags[$i]['object_type'] = 'attendee';
                    $arrAttendeeTags[$i]['tag_id'] = $tag['id'];
                    $i++;
                }

                $this->tag_relation_model->save_batch($arrTags);
                $this->tag_relation_model->save_batch($arrAttendeeTags);
            }

            $this->has_model->tableName = 'exhibitor_has_product_category';
            if (!is_null($id)) {
                $arrHasDelete = array("exhibitor_id" => $id);

                if (!$this->has_model->delete($arrHasDelete))
                    $error = TRUE;
            }

            if (isset($data['product_category_id']) && !empty($data['product_category_id'])) {
                $arrTags = array();
                foreach ($data['product_category_id'] as $industry) {
                    $arrTags[$i]['exhibitor_id'] = $exhibitor_id;
                    $arrTags[$i]['product_category_id'] = $industry;
                    $i++;
                }
                $this->has_model->save($arrTags);
            }


        } catch (Exception $e) {
            $error = true;
        }
        if ($error) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return true;
    }

    /**
     * save
     *
     * saves exhibitor
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function save($data, $id = NULL) {

        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
        if (!isset($arrData['status']))
            $arrData['status'] = 1;


        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();
            $result = $this->db->insert('exhibitor', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('exhibitor', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

    /**
     * check_email
     *
     * checks email
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  $email
     * @return  void
     */
    function check_email($email) {
        $this->db->select('email', $email);
        $query = $this->db->get('user');
        $result = $query->result();
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * get
     *
     * gets user
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get($id = NULL, $row = FALSE, $where = 'id') {

        if (!is_null($id))
            $this->db->where($where, $id);

        $this->db->where_in('status', $this->status);
        $this->db->order_by($this->order_name, $this->order_by);
        if ($row) {
            $result = $this->db->get('exhibitor')->row();

            return $result;
        } else {
            $result = $this->db->get('exhibitor');
            return $result->result_array();
        }
    }

    /**
     * getAll
     *
     * gets user
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $where = 'exhibitor.id', $type = 'LIKE', $drop_down_search = NULL) {
        // $this->db->order_by('exhibitor.created_date', 'desc'); // added code
        if ($search == 'NULL') {
            $this->db->order_by('exhibitor.created_date', 'desc');
        } else {
            $this->db->order_by($this->order_name, $this->order_by);
        }
        $this->db->select('exhibitor.id as exhibitor_id,exhibitor.*,exhibitor_profile.*,user.first_name as contact_name,user.last_name as last_name,attendee.phone as contact_phone,attendee.mobile as contact_mobile,user.email as contact_email,attendee.gcm_reg_id as contact_gcm_reg_id,attendee.mobile_os as contact_mobile_os,user2.username as username,passcode,exhibitor.user_id as user_id,event_has_attendee.status as exhibitor_status');
        if (!is_null($id) && $where == 'exhibitor.id')
            $this->db->select('attendee.industry as industry_id,
                     attendee.functionality as functionality_id,
        ,(select group_concat(exhibitor_has_product_category.product_category_id) from exhibitor_has_product_category where exhibitor_id = ' . $id . ') as product_category_id,   
        ', false);
        $this->db->select('organizer.name as organizer_name,event.name as event_name,event.id as event_id');
        $this->db->select('event.event_start ,event.event_end ,event_profile.location as event_location,event_profile.city as event_city, event_profile.country as event_country');
        $this->db->select('attendee.id as attendee_id');

        if (!is_null($id) && $where == 'exhibitor.id') {
            $this->db->select('(select group_concat(tag_name) as tag from tag
            INNER JOIN tag_relation ON tag_relation.tag_id = tag.id
            where object_id = ' . $id . ' AND object_type="exhibitor") as tag_name   
        
        ', false);
        }
        $superadmin = $this->session->userdata('is_superadmin');
        if (!$superadmin)
            $this->db->where('event.id', $this->event_id);

        if (!is_null($id))
            $this->db->where($where, $id);

        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                if ($type == 'LIKE') {
                    $where = "$field LIKE '%$search%'";
                    $this->db->or_where($where);
                } else if ($type == 'AND') {
                    $this->db->where($field, $search);
                    $this->db->where("exhibitor.event_id", $drop_down_search);
                } else if ($type = 'or') {
                    $this->db->or_where($field, $search);
                }
            }
        }
        $this->db->order_by($this->order_name, $this->order_by);
        $this->db->where_in('exhibitor.status', $this->status);
        $this->db->join('exhibitor_profile', 'exhibitor_profile.exhibitor_id = exhibitor.id');
        $this->db->join('user user2', 'exhibitor.user_id = user2.id');
        $this->db->join('event', 'exhibitor.event_id = event.id', 'left');
        $this->db->join('event_profile', 'event_profile.event_id = event.id', 'left');
        $this->db->join('organizer', 'event.organizer_id = organizer.id', 'left');
        $this->db->group_by('exhibitor.id');
        $this->db->join('user', 'exhibitor.contact_id = user.id');
        $this->db->join('attendee', 'user.id = attendee.user_id');
        $this->db->join('event_has_attendee', 'attendee.id = event_has_attendee.attendee_id AND event_has_attendee.event_id = event.id ');

        if ($row) {
            $result = $this->db->get('exhibitor')->row();
            return $result;
        } else {

            $result = $this->db->get('exhibitor');
//            echo '<pre>';echo $this->db->last_query();exit;
            return $result->result_array();
        }
    }

    /**
     * savePhoto
     *
     * gets all exhibitors
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function savePhoto(&$data, $form) {
        $return = true;

        foreach ($form['fields'] as $element) {

            if ($element['type'] == 'file' && $_FILES[$element['name']]['name'] != '') {
                $config = $element['upload_config'];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($element['name'])) {
                    $data[] = $this->upload->display_errors();
                    $return = false;
                } else {
                    $data[$element['name']] = $this->upload->file_name;
                    //return true;
                    //image resize code
                    $img_name = $this->upload->file_name;
                    $imgfile = UPLOAD_EXHIBITOR_LOGO_DISPLAY . $this->upload->file_name;
                    $imginfo = getimagesize($imgfile);
                    $width = $imginfo[0];
                    $height = $imginfo[1];
                    $newwidth = $config['width'];
                    $newheight = $config['height'];

                    if ($imginfo['mime'] == 'image/jpeg') {
                        $tmpb = imagecreatetruecolor($newwidth, $newheight);
                        //echo '<pre>'; print_r($tmpb); exit;
                        $tes = imagecopyresampled($tmpb, imagecreatefromjpeg($imgfile), 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        //echo '<pre>'; print_r($tes); exit;
                        unlink($imgfile);
                        imagejpeg($tmpb, $imgfile, 90);
                    } elseif ($imginfo['mime'] == 'image/png') {

                        $image = imagecreatefrompng($imgfile);
                        $new_image = imagecreatetruecolor($newwidth, $newheight); // new wigth and height
                        imagealphablending($new_image, false);
                        imagesavealpha($new_image, true);
                        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $newwidth, $newheight, imagesx($image), imagesy($image));
                        $image = $new_image;

                        // saving
                        imagealphablending($image, false);
                        imagesavealpha($image, true);
                        imagepng($image, $imgfile);
                    }
                }
            }
        }

        return $return;
    }

    /**
     * delete
     *
     * delete cms 
     * @author	Ruchira Shree
     * @access	public
     * @param array $arrData,Integer $id
     * @return	array
     */
    function delete($arrData) {
        $this->db->where_in('id', $arrData);
        if ($this->db->delete('exhibitor')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check_exhibitor
     *
     * checks if exhibitor exist
     * 
     * @author  Aatsih 
     * @access  public
     * @params  array $data 
     * @params  $email
     * @return  void
     */
    function check_exhibitor($where = array()) {
//        $this->db->select('id');
        $this->db->select('exhibitor.id as exhibitor_id,exhibitor.*,exhibitor_profile.*');
        if (isset($where['city']) && isset($where['country']) && isset($where['email']) && isset($where['event_id']) && isset($where['name'])) {
            $city = $where['city'];
            $country = $where['country'];
            $event_id = $where['event_id'];
            $name = $where['name'];
            $email = $where['email'];
            $this->db->where('city', $city);
            $this->db->where('country', $country);
            $this->db->where('event_id', $event_id);
            $this->db->where('name', $name);
            $this->db->or_where('user.email', $email);
        } else {
            $this->db->where($where);
        }
//        $this->db->where($where);
        $this->db->join('user', 'user.id = exhibitor.contact_id');
        $this->db->join('exhibitor_profile', 'exhibitor_profile.exhibitor_id = exhibitor.id');
        $result = $this->db->get('exhibitor')->row();
//        $this->db->where($field . ' IS NOT NULL');
        if ($result) {
            return $result->exhibitor_id;
        } else {
            return FALSE;
        }
    }

    function sendMail($data = array()) {
        if (empty($data))
            return false;
        $status = true;
        foreach ($data as $id) {
            $objOrg = $this->getAll($id, true);
            //echo '<pre>'; print_r($objOrg); exit;
            if ($objOrg->contact_email != '') {
                $to = $objOrg->contact_email;
                $selected_event = $objOrg->event_id;
                if ($this->session->userdata('selected_event')) {
                    $selected_event = $this->session->userdata('selected_event');
                }
//                display($objOrg);
//                die;
                //MAIL TEMLATE***
                $email_template = get_email_template('email_for_event_subscribtion_exhibitor');
                $keywords = array('{app_name}', '{event_name}', '{duration}', '{address}', '{first_name}', ' {exhibitor_user_name}', '{passcode}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
                $replace_with = array(
                    $email_template['setting']['app_name'],
                    $objOrg->event_name,
                    date('Y-m-d', strtotime($objOrg->event_start)) . " To " . date('Y-m-d', strtotime($objOrg->event_end)),
                    $objOrg->event_location . ',' . $objOrg->event_city . ',' . $objOrg->event_country,
                    $objOrg->contact_name,
                    $objOrg->username,
                    $objOrg->passcode,
                    $email_template['setting']['app_contact_email'],
                    SITE_URL,
                    CLIENT_IMAGES,
                    '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                );
                $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                $html = str_replace($keywords, $replace_with, $email_template['body']);
                //MAIL TEMLATE CLOSE***

                if (sendMail($to, $subject, $html)) {
                    //"mail successfully";
                    $this->db->where('event_id', $objOrg->event_id);
                    $this->db->where('attendee_id', $objOrg->attendee_id);
                    $arrData = array('approve_by_org' => 1, 'mail_sent' => 1);
                    $this->db->update('event_has_attendee', $arrData);
                    $exarrData = array('mail_sent' => 1);
                    $this->db->where('id', $objOrg->exhibitor_id);
                    $this->db->update('exhibitor', $exarrData);
                    $arrData['mail_sent'] = 1;
                    $this->save($arrData, $id);
                }

                /* sendMail($to, $subject, $message);
                  $arrData['mail_sent'] = 1;
                  $this->save($arrData, $id); */
            } else {
                $status = false;
            }
        }
        return $status;
    }

    /**
     * check_unique
     *
     * Checks uniqueness of exhibitor with name and event id & city
     * 
     * @author  Rohan
     * @access  public
     * @params  company name
     * @params  event id
     * @return  void
     */
    function check_unique($name, $city, $event, $id = null) {
        $this->db->where('exhibitor.event_id', $event);
        $this->db->where('exhibitor.name', $name);
        $this->db->where('exhibitor_profile.city', $city);
        $this->db->join('exhibitor_profile', 'exhibitor_profile.exhibitor_id = exhibitor.id');
        $result = $this->db->get('exhibitor');
        $res = $result->result_array();
        //echo '<pre>'; print_r($id); exit;
        if (!is_null($id)) {
            if ($id == $res[0]['id']) {
                return FALSE;
            }
        } else {
            if (!empty($res)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    function by_pass_passcode($data = array()) {
//        display($data);die;
        //echo '1541';exit;
        if (empty($data))
            return false;
        $status = true;
        $count = 0;
        foreach ($data as $id) {

            $objAttend = $this->getAll($id, true);
            $selected_event = $objAttend->event_id;
            if ($this->session->userdata('selected_event')) {
                $selected_event = $this->session->userdata('selected_event');
            }
            //if($objAttend->subscribe_email == 1) {
            $this->db->where('event_id', $selected_event);
            $this->db->where('attendee_id', $objAttend->attendee_id);
            $arrData = array('approve_by_org' => 1, 'mail_sent' => 1, 'status' => 1);
            $this->db->update('event_has_attendee', $arrData);
            $arrData['mail_sent'] = 1;
            $this->save($arrData, $id);
        }
        //echo '<br>'.$count; 
        //exit;
        return $status;
//        die('adf');
    }

}

?>