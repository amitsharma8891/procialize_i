<?php

class speaker_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    public $object;
    public $event_id;
    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'attendee.id';
    public $limit = NULL;
    public $fields = array(
        "id",
        "name",
        "description",
        "speaker_photo",
        "speaker_profile",
        "city",
        "country",
        "website_link",
        "status",
        "mail_sent",
        "event_id",
        "created_by",
        "created_date",
        "user_id",
        "pvt_org_id",
    );

    function generate_fields($id = NULL) {
        $superadmin = $this->session->userdata('is_superadmin');

        $arrResult = array();
        if (!is_null($id)) {
            $arrResult = $this->getAll($id, TRUE);
            $this->object = $arrResult;
            //echo '<pre>'; print_r($arrResult); exit;
            if ($arrResult->photo == '') {
                unset($arrResult->photo);
            }
            if (array_key_exists('profile', $arrResult)) {
                if ($arrResult->profile == '') {
                    unset($arrResult->profile);
                }
            }
        }

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


        if (isset($arrResult->photo)) {
            $speaker_photo = '<img src="' . base_url() . UPLOAD_SPEAKER_LOGO_DISPLAY . $arrResult->photo . '" alt="normal_ad">';
        } else {
            $speaker_photo = '<img src="http://placehold.it/106x64" alt="">';
        }
//speaker_profile
        if (isset($arrResult->profile)) {
            $speaker_profile = '<img src="' . base_url() . UPLOAD_SPEAKER_LOGO_DISPLAY . $arrResult->profile . '" alt="normal_ad">';
        } else {
            $speaker_profile = '<img src="http://placehold.it/106x64" alt="">';
        }

        //  echo '<pre>';print_r($arrResult);exit;
        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'event_id' => array(
                "type" => "hidden",
                "event_id" => isset($this->event_id) ? $this->event_id : '',
            ),
            'first_name' => array("name" => "first_name",
                "type" => "text",
                "id" => "first_name",
                "class" => "form-control validate[required]",
                "placeholder" => "First Name*",
                "validate" => 'required',
                "error" => 'First Name',
                "value" => set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : (isset($postarray['first_name']) ? $postarray['first_name'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Full Name<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'last_name' => array("name" => "last_name",
                "type" => "text",
                "id" => "last_name",
                "class" => "form-control",
                "placeholder" => "Last Name",
                //"validate" => 'required',
                "error" => 'Last Name',
                "value" => set_value('last_name', (isset($arrResult->last_name) && ($arrResult->last_name != '') ? $arrResult->last_name : (isset($postarray['last_name']) ? $postarray['last_name'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "close",
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
                        "content" => '<div>Last Name</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'company_name' => array("name" => "company_name",
                "type" => "text",
                "id" => "company_name",
                "class" => "form-control",
                "placeholder" => "Company",
                "validate" => '',
                "error" => 'Company',
                "value" => set_value('company_name', (isset($arrResult->company_name) && ($arrResult->company_name != '') ? $arrResult->company_name : (isset($postarray['company_name']) ? $postarray['company_name'] : ''))),
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
                        "content" => '<div>Company</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'designation' => array("name" => "designation",
                "type" => "text",
                "id" => "designation",
                "class" => "form-control",
                "placeholder" => "Designation",
                "validate" => '',
                "error" => 'Designation',
                "value" => set_value('designation', (isset($arrResult->designation) && ($arrResult->designation != '') ? $arrResult->designation : (isset($postarray['designation']) ? $postarray['designation'] : ''))),
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
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Designation</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'description' => array("name" => "description",
                "type" => "textarea",
                "maxlength" => "200",
                "id" => "description",
                "class" => "form-control",
                "rows" => '5',
                "placeholder" => "Description (Maximum 200 words)",
                "validate" => '',
                "error" => 'Description',
                "value" => set_value('description', (isset($arrResult->description) && ($arrResult->description != '') ? $arrResult->description : (isset($postarray['description']) ? $postarray['description'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group",
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
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">Upload Information</h3>
                                    <span class="help-block col-sm-12">Uploads must be PDF/ DOC/ DOCX/ JPG/ or PNG and smaller than 3MB</span>',
                        "position" => "appendOuter",
                    ),
                ),
            ),
            'photo' => array(
                "name" => "photo",
                "type" => "file",
                "id" => "normal_ad",
                "class" => "form-control",
                "placeholder" => "Speaker Photo",
                "upload_config" => array(
                    "upload_path" => UPLOAD_SPEAKER_LOGO,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Speaker Logo',
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-1"
                    ),
                    array(
                        "tag" => "div",
                        "class" => "fileinput fileinput-new",
                        "close" => 'true',
                        "attribute" => 'data-provides="fileinput"',
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $speaker_photo . '</div>',
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
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Speaker Pic</span><span class="fileinput-exists">Change Pic</span>',
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-1",
                        "content" => "" . (isset($arrResult->logo) ? '<img src="' . base_url() . UPLOAD_SPEAKER_LOGO_DISPLAY . $arrResult->logo . '" width="50" />' : ''),
                        "position" => "appendOuter",
                    ),
                ),
            ),
            'profile' => array(
                "name" => "profile",
                "type" => "file",
                "id" => "normal_ad",
                "class" => "form-control",
                "placeholder" => "Speaker Profile",
                "upload_config" => array(
                    "upload_path" => UPLOAD_SPEAKER_LOGO,
                    "allowed_types" => 'jpg|png|jpeg|pdf|doc|docx',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Speaker Profile',
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-1"
                    ),
                    array(
                        "tag" => "div",
                        "class" => "fileinput fileinput-new",
                        "close" => 'true',
                        "attribute" => 'data-provides="fileinput"',
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $speaker_profile . '</div>',
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
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Speaker Profile</span><span class="fileinput-exists">Change Speaker Profile</span>',
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-1",
                        "content" => "" . (isset($arrResult->logo) ? '<img src="' . base_url() . UPLOAD_SPEAKER_LOGO_DISPLAY . $arrResult->logo . '" width="50" />' : ''),
                        "position" => "appendOuter",
                    ),
                ),
            ),
            'industry' => array("name" => "industry_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "attributes" => ' multiple data-placeholder="Select Industry"',
                "class" => "form-control chosen-select validate[required]",
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
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">General Information</h3>',
                        "position" => "prependOuter",
                    ),
                ),
            ),
            'functionality' => array("name" => "functionality_id[]",
                "type" => "dropdown",
                "id" => "functionality_id",
                "class" => "form-control chosen-select validate[required]",
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
            'website' => array("name" => "website",
                "type" => "text",
                "id" => "website",
                "class" => "form-control",
                "placeholder" => "Speaker Website Link",
                "validate" => '',
                "error" => 'Website Link',
                "value" => set_value('website_link', (isset($arrResult->website) && ($arrResult->website != '') ? $arrResult->website : (isset($postarray['website']) ? $postarray['website'] : ''))),
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
                        "content" => '<div>Speaker Website Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'facebook' => array("name" => "facebook",
                "type" => "text",
                "id" => "facebook",
                "class" => "form-control ",
                "placeholder" => "Speaker Facebook Link",
                "validate" => '',
                "error" => 'Facebook Link',
                "value" => set_value('facebook', (isset($arrResult->facebook) && ($arrResult->facebook != '') ? $arrResult->facebook : (isset($postarray['facebook']) ? $postarray['facebook'] : ''))),
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
                        "content" => '<div>Speaker Facebook Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            /* 'twitter' => array("name" => "twitter",
              "type" => "text",
              "id" => "twitter",
              "class" => "form-control",
              "placeholder" => "Speaker Twitter Link",
              "validate" => '',
              "error" => 'Twitter Link',
              "value" => set_value('twitter', (isset($arrResult->twitter) && ($arrResult->twitter != '') ? $arrResult->twitter : (isset($postarray['twitter']) ? $postarray['twitter'] : ''))),
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
              "content" => '<div>Speaker Twitter Link</div>',
              "position" => "prependElement",
              ),
              ),
              ), */
            'linkden' => array("name" => "linkden",
                "type" => "text",
                "id" => "linkden",
                "class" => "form-control ",
                "placeholder" => "Speaker Linkedin Link",
                "validate" => '',
                "error" => 'Linkedin Link',
                "value" => set_value('linkden', (isset($arrResult->linkden) && ($arrResult->linkden != '') ? $arrResult->linkden : (isset($postarray['linkden']) ? $postarray['linkden'] : ''))),
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
                        "content" => '<div>Speaker Linkedin Link</div>',
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
            //Anupam
            'email' => array("name" => "email",
                "type" => "text",
                "id" => "email",
                "class" => "form-control  validate[required]",
                "placeholder" => "Contact Email ID*",
                "validate" => 'required',
                "error" => 'Contact Email',
                "value" => set_value('email', (isset($arrResult->email) ? $arrResult->email : (isset($postarray['email']) ? $postarray['email'] : ''))),
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
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Contact Email ID<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">Contact Details</h3>',
                        "position" => "prependOuter",
                    ),
                ),
            ),
            'phone' => array("name" => "phone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control",
                "placeholder" => "Phone Number",
                "validate" => '',
                "error" => 'Phone Number',
                "value" => set_value('phone', (isset($arrResult->phone) && ($arrResult->phone != '') ? $arrResult->phone : (isset($postarray['phone']) ? $postarray['phone'] : ''))),
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
                        "content" => '<div>Phone Number</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'mobile' => array("name" => "mobile",
                "type" => "text",
                "id" => "mobile",
                "class" => "form-control",
                "placeholder" => "Mobile Number",
                "validate" => '',
                "error" => 'Mobile Number',
                "value" => set_value('mobile', (isset($arrResult->mobile) && ($arrResult->mobile != '') ? $arrResult->mobile : (isset($postarray['mobile']) ? $postarray['mobile'] : ''))),
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
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Mobile Number</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'status' => array(
                "name" => "status",
                "type" => "dropdown",
                "id" => "form-status",
                "class" => "form-control chosen-select",
                "attributes" => '  data-placeholder="Status" ',
                "placeholder" => "Status",
                "options" => array("1" => "Status - Enabled", "0" => "Status - Disabled"),
                "validate" => 'required',
                "error" => 'Functionality',
                "value" => set_value('status', (isset($arrResult->status) ? $arrResult->status : $this->input->post('status'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
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
                        "content" => '<div>Status</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            //bhavana end
            'user_id' => array(
                "type" => "hidden",
                "user_id" => isset($arrResult->user_id) ? $arrResult->user_id : '',
            ),
        );
        if ($superadmin) {
            $arrData['fields']['event_id'] = array("name" => "event_id",
                "type" => "dropdown",
                "id" => "event_id",
                "class" => "form-control chosen-select",
                "attributes" => '  data-placeholder="Select Events" ',
                "placeholder" => "Events *",
                "options" => $this->event_model->getDropdownValues(),
                "validate" => 'required',
                "error" => 'Functionality',
                "value" => set_value('event_id', isset($arrResult->event_id) ? $arrResult->event_id : $this->input->post('event_id')),
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
                ),
            );
        }
        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/speaker/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/speaker/add';
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
        try {
            $this->db->trans_begin();

            if (is_null($id)) {
                //echo '<pre>'; print_r($data); exit;
                # save User as Sponsor
                //echo '<pre>'; print_r($data); exit;
                $user_id = $this->user_model->save($data);
                //echo $user_id; exit;
                $data['user_id'] = $user_id;
            }
            #save contact person as attendee
            unset($data['username']);
            unset($data['password']);
            if (is_null($id)) {
                $data['status'] = 1;
                $speaker_id = $this->save($data, $id);
                //$data['speaker_id'] = $speaker_id;

                if (isset($data['industry_id'])) {
                    $arrTags = array();
                    foreach ($data['industry_id'] as $industry) {
                        $arrTags[$i]['speaker_id'] = $speaker_id;
                        $arrTags[$i]['industry_id'] = $industry;
                        $i++;
                    }
                    $this->has_model->tableName = 'speaker_has_industry';
                    if (!is_null($id)) {
                        $arrHasDelete = array("speaker_id" => $id);

                        if (!$this->has_model->delete($arrHasDelete))
                            $error = TRUE;
                    }
                    $this->has_model->save($arrTags);
                }
                if (isset($data['functionality_id'])) {
                    $arrTags = array();
                    foreach ($data['functionality_id'] as $functionality) {
                        $arrTags[$i]['speaker_id'] = $speaker_id;
                        $arrTags[$i]['functionality_id'] = $functionality;
                        $i++;
                    }
                    $this->has_model->tableName = 'speaker_has_functionality';
                    if (!is_null($id)) {
                        $arrHasDelete = array("speaker_id" => $id);

                        if (!$this->has_model->delete($arrHasDelete))
                            $error = TRUE;
                    }
                    $this->has_model->save($arrTags);
                }
            } else {
                //echo 'asd<pre>'; print_r($data); exit;
                $user_id = $this->user_model->save($data, $data['user_id']);
                //echo '<pre>'; print_r($data); exit;
                $speaker_id = $this->save($data, $id);

                if (isset($data['industry_id'])) {
                    $arrTags = array();
                    foreach ($data['industry_id'] as $industry) {
                        $arrTags[$i]['speaker_id'] = $speaker_id;
                        $arrTags[$i]['industry_id'] = $industry;
                        $i++;
                    }
                    $this->has_model->tableName = 'speaker_has_industry';
                    if (!is_null($id)) {
                        $arrHasDelete = array("speaker_id" => $id);

                        if (!$this->has_model->delete($arrHasDelete))
                            $error = TRUE;
                    }
                    $this->has_model->save($arrTags);
                }
                if (isset($data['functionality_id'])) {
                    $arrTags = array();
                    foreach ($data['functionality_id'] as $functionality) {
                        $arrTags[$i]['speaker_id'] = $speaker_id;
                        $arrTags[$i]['functionality_id'] = $functionality;
                        $i++;
                    }
                    $this->has_model->tableName = 'speaker_has_functionality';
                    if (!is_null($id)) {
                        $arrHasDelete = array("speaker_id" => $id);

                        if (!$this->has_model->delete($arrHasDelete))
                            $error = TRUE;
                    }
                    $this->has_model->save($arrTags);
                }
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
     * saves sponsor
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

            $result = $this->db->insert('speaker', $arrData);
            $id = $this->db->insert_id();
        } else {

            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            //echo '<pre>'; print_r($arrData); exit;
            $this->db->where('id', $id);
            $result = $this->db->update('speaker', $arrData);
        }
        if ($result) {
            return $id;
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
    function get($id = NULL, $row = FALSE) {

        if (!is_null($id))
            $this->db->where('id', $id);

        $this->db->where_in('status', $this->status);
        if ($row) {
            $result = $this->db->get('speaker')->row();

            return $result;
        } else {
            $result = $this->db->get('speaker');
            return $result->result_array();
        }
    }

    /**
     * get
     *
     * gets attendee
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $type = 'LIKE', $where = 'attendee.id', $drop_down_search = NULL) {

        if (!is_null($id))
            $this->db->where($where, $id);
        // $this->db->order_by($this->order_name, $this->order_by); //aatish code
        if ($search == 'NULL') {
            $this->db->order_by('attendee.created_date', 'desc');
        } else {
            $this->db->order_by($this->order_name, $this->order_by);
        }
        if (!is_null($id))
            $this->db->select('attendee.industry as industry_id,
                        attendee.functionality as functionality_id'
                    , false);
        $this->db->select('attendee.id as attendee_id,user.id as user_id,attendee.*,user.*');
        $this->db->select('event.name as event_name,organizer.name as organizer_name,event.id as event_id,event_has_attendee.passcode,event_has_attendee.status as speaker_status');
        $this->db->select('event.event_start ,event.event_end ,event_profile.location as event_location,event_profile.city as event_city, event_profile.country as event_country');

        $this->db->join('user', 'user.id = attendee.user_id', 'left');
        $this->db->join('event_has_attendee', 'event_has_attendee.attendee_id = attendee.id');
        $this->db->join('event', 'event_has_attendee.event_id = event.id', 'left');
        $this->db->join('event_profile', 'event_profile.event_id = event.id', 'left');
        $this->db->join('organizer', 'organizer.id = event.organizer_id', 'left');
        if (!is_null($this->limit))
            $this->db->limit($this->limit, $this->offset);
        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                if ($type == 'LIKE') {
                    $where = "$field LIKE '%$search%'";
                    $this->db->or_where($where);
                } else if ($type == 'AND') {

                    $this->db->where($field, $search);
                    $this->db->where("event_has_attendee.event_id", $drop_down_search);
                } else if ($type = 'or') {
                    $this->db->or_where($field, $search);
                }
            }
        }
        $this->db->where('attendee_type', 'S');

        if (!is_null($id)) {
            $this->db->select('(select group_concat(tag_name) as tag from tag
            INNER JOIN tag_relation ON tag_relation.tag_id = tag.id
            where object_id = ' . $id . ' AND object_type="attendee") as tag_name   
        
        ', false);
        }
        $superadmin = $this->session->userdata('is_superadmin');
        if (!$superadmin)
            $this->db->where('event.id', $this->event_id);

        $this->db->group_by('attendee_id');
        if ($row) {
            $result = $this->db->get('attendee')->row();

            return $result;
        } else {
            $result = $this->db->get('attendee');
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
                    //Image resize code.
                    $img_name = $this->upload->file_name;
                    $imgfile = UPLOAD_SPEAKER_LOGO_DISPLAY . $this->upload->file_name;
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
     * delete 
     * @author  Rohan
     * @access  public
     * @param array $arrData,Integer $id
     * @return  array
     */
    function delete($arrData) {
        $this->db->where_in('id', $arrData);
        if ($this->db->delete('speaker')) {
            return true;
        } else {
            return false;
        }
    }

    function sendMail($data = array()) {
        if (empty($data))
            return false;
        foreach ($data as $id) {
            $objOrg = $this->getAll($id, true);
//           echo '<pre>'; print_r($objOrg);exit;
            if ($objOrg->email != '' && $objOrg->mail_sent == 0) {
//               //        sendMail($to, $subject, $message)
                $arrData['mail_sent'] = 1;
                $this->save($arrData, $id);
            }
        }
    }

    /**
     * check_unique
     *
     * Checks uniqueness of sponsor with name and event id
     * 
     * @author  Rohan
     * @access  public
     * @params  company name
     * @params  event id
     * @return  void
     */
    function check_unique($first_name, $email, $event_id, $id = null) {

        $this->db->select('speaker.id as speaker_id, speaker.*');
        $this->db->select('user.*');
        $this->db->join('user', 'speaker.user_id = user.id');
        $this->db->where('speaker.name', $first_name);
        $this->db->where('user.email', $email);
        $this->db->where('speaker.event_id', $event_id);
        $this->db->distinct();
        $result = $this->db->get('speaker');

        $res = $result->result_array();
        //echo '<pre>'; print_r($res); exit;
        if (!is_null($id)) {
            if ($id == $res[0]['speaker_id']) {
                return FALSE;
            }
        } else {
            if (!empty($res)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }


        /* if ($res > 0) {
          return TRUE;
          } else {
          return FALSE;
          } */
    }

    function getDropdownValuesForEvent($id = NULL, $select = true) {
        $dropDownValues = array();
        $this->db->where('event.id', $this->event_id);
        $dropDownValues = $this->getAll();
//        echo $this->db->last_query();
        $arrDropdown = array();
        if ($select)
            $arrDropdown[''] = 'Select Speaker';
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['attendee_id']] = $value['name'];
        }
        return $arrDropdown;
    }

    function by_pass_passcode($data = array()) {
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
            if (isset($objAttend->subscribe_email)) {
                $count++;
                $this->db->where('event_id', $selected_event);
                $this->db->where('attendee_id', $objAttend->attendee_id);
                $arrData = array('approve_by_org' => 1, 'mail_sent' => 1, 'status' => 1);
                $this->db->update('event_has_attendee', $arrData);
                $arrData['mail_sent'] = 1;
                $this->save($arrData, $id);
            }
        }
        return $status;
    }

}

?>