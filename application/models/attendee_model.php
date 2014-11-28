<?php

class attendee_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    public $object = NULL;
    public $id = NULL;
    public $limit = NULL;
    public $offset = 0;
    public $event_id;
    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'attendee.id';
//    public $attendee_type = array('A', 'E','S');
    public $attendee_type = array('A', 'E');
//    public $attendee_type = array('A');
    public $fields = array(
        "id",
        "name",
        "description",
        "location",
        "city",
        "country",
        "latitude",
        "longitude",
        "website",
        "linkden",
        "twitter",
        "facebook",
        "photo",
        "profile",
        "mail_sent",
        "status",
        "created_by",
        "created_date",
        "association",
        "spk_ex_id",
        "spk_ex_type",
        "user_id",
        "pvt_org_id",
        "attendee_type",
        "event_id",
        "gcm_reg_id",
        "mobile_os",
        "company_name",
        "designation",
        "phone",
        "mobile",
        "industry",
        "functionality",
    );

    /**
      Bhavana
     */
    function mobileno_check($no) {
        if (!preg_match("/^[0-9 -+]+$/", $no) && !is_numeric($no)) {

            $this->form_validation->set_message('mobileno_check', 'Invalid Mobile No!');
            return FALSE;
        } else
            return TRUE;
    }

    /**
     * generate_fields
     *
     * generates form field elements
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  null
     * @return  void
     */
    function generate_fields($id = NULL) {
        $superadmin = $this->session->userdata('is_superadmin');
        $arrResult = array();
        if (!is_null($id)) {
            $arrResult = $this->getAll($id, TRUE);
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
//          echo '<pre>';print_r($arrResult);exit;
        if ($superadmin)
            $this->event_id = isset($arrResult->event_id) ? $arrResult->event_id : '';


        if (isset($arrResult->photo)) {
            $up_photo = '<img src="' . base_url() . UPLOAD_ATTENDEE_PHOTO_DISPLAY . $arrResult->photo . '" alt="photo">';
        } else {
            $up_photo = '<img src="http://placehold.it/106x64" alt="photo">';
        }

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            /**/

            'event_id' => array(
                "type" => "hidden",
                "event_id" => isset($this->event_id) ? $this->event_id : '',
            ),
            'first_name' => array("name" => "first_name",
                "type" => "text",
                "id" => "first_name",
                "class" => "form-control  validate[required]",
                "placeholder" => "First Name*",
                "validate" => 'required',
                "error" => 'First Name',
                "value" => set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : (isset($postarray['first_name']) ? $postarray['first_name'] : ''))),
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
                        "content" => '<div>First Name<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'last_name' => array("name" => "last_name",
                "type" => "text",
                "id" => "last_name",
                "class" => "form-control ",
                "placeholder" => "Last Name",
                "validate" => '',
                "error" => 'Last Name',
                "value" => set_value('last_name', ((isset($arrResult->last_name)) && ($arrResult->last_name != '') ? $arrResult->last_name : (isset($postarray['last_name']) ? $postarray['last_name'] : ''))),
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
                        "content" => '<div>Last Name </div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
//            'Tag' => array("name" => "tag_name",
//                "type" => "text",
//                "id" => "tags",
//                "class" => "form-control ",
//                "placeholder" => "Add a tags",
//                "validate" => '',
//                "error" => 'Last Name',
//                "value" => set_value('tag', (isset($arrResult->tag_name) && ($arrResult->tag_name != '') ? '' : (isset($postarray['tag_name']) ? $postarray['tag_name'] : ''))),
//                "decorators" => array(
//                    array(
//                        "tag" => "div",
//                        "close" => "true",
//                        "class" => "col-sm-3"
//                    ),
//                    array("tag" => "div",
//                        "close" => "close",
//                    ),
//                    array(
//                        "tag" => "lable",
//                        "close" => "false",
//                        "class" => "col-sm-1 control-label form-label-placeholder",
//                        "content" => '<div>Tag</div>',
//                        "position" => "prependElement",
//                    ),
//                ),
//            ),
            'company_name' => array("name" => "company_name",
                "type" => "text",
                "id" => "company_name",
                "class" => "form-control",
                "placeholder" => "Comapny Name",
                "validate" => '',
                "error" => 'Company Name',
                "value" => set_value('company_name', ((isset($arrResult->company_name)) && ($arrResult->company_name != '') ? $arrResult->company_name : (isset($postarray['company_name']) ? $postarray['company_name'] : ''))),
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
                        "content" => '<div>Comapny Name</div>',
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
                    array("tag" => "div",
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
                "id" => "photo",
                "class" => "form-control",
                "placeholder" => "photo",
                "validate" => "",
                "upload_config" => array(
                    "upload_path" => UPLOAD_ATTENDEE_PHOTO,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Photo',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $up_photo . '</div>',
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
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Attendee Logo<br>(180px x 180px)</span><span class="fileinput-exists">Change Logo</span>',
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">General Information</h3>',
                        "position" => "appendOuter",
                    ),
                ),
            ),
            'latitude' => array(
                "type" => "hidden",
                "latitude" => set_value('latitude', (isset($arrResult->latitude) ? $arrResult->latitude : '')),
            ),
            'longitude' => array(
                "type" => "hidden",
                "longitude" => set_value('longitude', (isset($arrResult->longitude) ? $arrResult->longitude : '')),
            ),
            'industry' => array("name" => "industry_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "attributes" => ' multiple data-placeholder="Select Industry"',
                "class" => "form-control chosen-select",
                "placeholder" => "Industry",
                "validate" => '',
                "error" => 'Industry',
                "options" => $this->industry_model->getDropdownValues(),
                "value" => set_value('industry_id', (isset($arrResult->industry_id) ? explode(',', $arrResult->industry_id) : (isset($postarray['industry_id']) ? $postarray['industry_id'] : ''))),
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
                "class" => "form-control chosen-select",
                "attributes" => ' multiple data-placeholder="Select Functionality"',
                "placeholder" => "Functionality",
                "options" => $this->functionality_model->getDropdownValues(),
                "validate" => '',
                "error" => 'Functionality',
                "value" => set_value('functionality_id', (isset($arrResult->functionality_id) ? explode(',', $arrResult->functionality_id) : (isset($postarray['functionality_id']) ? $postarray['functionality_id'] : ''))),
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
                "placeholder" => "Attendee Website Link",
                "validate" => '',
                "error" => 'Website Link',
                "value" => set_value('website', (isset($arrResult->website) && ($arrResult->website != '') ? $arrResult->website : (isset($postarray['website']) ? $postarray['website'] : ''))),
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
                        "content" => '<div>Attendee Website Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'facebook' => array("name" => "facebook",
                "type" => "text",
                "id" => "facebook",
                "class" => "form-control ",
                "placeholder" => "Attendee Facebook Link",
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
                        "content" => '<div>Attendee Facebook Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            /* 'twitter' => array("name" => "twitter",
              "type" => "text",
              "id" => "twitter",
              "class" => "form-control",
              "placeholder" => "Attendee Twitter Link",
              "validate" => '',
              "error" => 'Twitter Link',
              "value" => set_value('twitter', (isset($arrResult->twitter) && ($arrResult->twitter != '')  ? $arrResult->twitter : (isset($postarray['twitter']) ? $postarray['twitter'] : ''))),
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
              "content" => '<div>Attendee Twitter Link</div>',
              "position" => "prependElement",
              ),
              ),
              ), */
            'linkden' => array("name" => "linkden",
                "type" => "text",
                "id" => "linkden",
                "class" => "form-control ",
                "placeholder" => "Attendee Linkedin Link",
                "validate" => '',
                "error" => 'linkden Link',
                "value" => set_value('linkden', (isset($arrResult->linkden) && ($arrResult->linkden != '') ? $arrResult->linkden : (isset($postarray['linkden']) ? $postarray['linkden'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Attendee Linkedin Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
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
                        "close" => "false",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Contact Email ID<span class="field_required">*</span></div>',
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
            'phone' => array("name" => "phone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control validate[custom[phone]]",
                //"class" => "form-control required|regex_match[/^[0-9]+$/]|xss_clean",
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
                "class" => "form-control validate[custom[phone]]",
                // "class" => "form-control validate[numeric]",
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
                "validate" => '',
                "error" => 'Functionality',
                "value" => set_value('status', (isset($arrResult->status) && ($arrResult->status != '') ? $arrResult->status : (isset($postarray['status']) ? $postarray['status'] : ''))),
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
        );
//        echo $this->event_id;exit;
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
                "value" => set_value('event_id', (($this->event_id != '') ? $this->event_id : (isset($postarray['event_id']) ? $postarray['event_id'] : ''))),
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
            $arrData['action'] = base_url() . 'manage/attendee/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/attendee/add';
        }
        setcookie("postarray", "", time() - 3600);
        $arrData['fileUpload'] = TRUE;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * generate_fields
     *
     * generates form field elements
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  null
     * @return  void
     */
    function generate_fields_quick($id = NULL) {
        $superadmin = $this->session->userdata('is_superadmin');


        $arrResult = array();
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
//          echo '<pre>';print_r($arrResult);exit;
        if ($superadmin)
            $this->event_id = isset($arrResult->event_id) ? $arrResult->event_id : '';


        $arrData['fields'] = array();
        $arrData['fields'] = array(
            /**/

            'event_id' => array(
                "type" => "hidden",
                "event_id" => isset($this->event_id) ? $this->event_id : '',
            ),
            'first_name' => array("name" => "first_name",
                "type" => "text",
                "id" => "first_name",
                "class" => "form-control  validate[required]",
                "placeholder" => "First Name*",
                "validate" => 'required',
                "error" => 'First Name',
                "value" => set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : (isset($postarray['first_name']) ? $postarray['first_name'] : ''))),
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
                        "content" => '<div>First Name<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'last_name' => array("name" => "last_name",
                "type" => "text",
                "id" => "last_name",
                "class" => "form-control ",
                "placeholder" => "Last Name",
                "validate" => '',
                "error" => 'Last Name',
                "value" => set_value('last_name', ((isset($arrResult->last_name)) && ($arrResult->last_name != '') ? $arrResult->last_name : (isset($postarray['last_name']) ? $postarray['last_name'] : ''))),
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
                        "content" => '<div>Last Name </div>',
                        "position" => "prependElement",
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                ),
            ),
            'company_name' => array("name" => "company_name",
                "type" => "text",
                "id" => "company_name",
                "class" => "form-control",
                "placeholder" => "Comapny Name",
                "validate" => '',
                "error" => 'Company Name',
                "value" => set_value('company_name', ((isset($arrResult->company_name)) && ($arrResult->company_name != '') ? $arrResult->company_name : (isset($postarray['company_name']) ? $postarray['company_name'] : ''))),
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
                        "content" => '<div>Comapny Name</div>',
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
                    array("tag" => "div",
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
            'industry' => array("name" => "industry_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "attributes" => ' multiple data-placeholder="Select Industry"',
                "class" => "form-control chosen-select",
                "placeholder" => "Industry",
                "validate" => '',
                "error" => 'Industry',
                "options" => $this->industry_model->getDropdownValues(),
                "value" => set_value('industry_id', (isset($arrResult->industry_id) ? explode(',', $arrResult->industry_id) : (isset($postarray['industry_id']) ? $postarray['industry_id'] : ''))),
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
                "class" => "form-control chosen-select",
                "attributes" => ' multiple data-placeholder="Select Functionality"',
                "placeholder" => "Functionality",
                "options" => $this->functionality_model->getDropdownValues(),
                "validate" => '',
                "error" => 'Functionality',
                "value" => set_value('functionality_id', (isset($arrResult->functionality_id) ? explode(',', $arrResult->functionality_id) : (isset($postarray['functionality_id']) ? $postarray['functionality_id'] : ''))),
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
                ),
            ),
        );
//        echo $this->event_id;exit;
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
                "value" => set_value('event_id', (($this->event_id != '') ? $this->event_id : (isset($postarray['event_id']) ? $postarray['event_id'] : ''))),
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
            $arrData['action'] = base_url() . 'manage/attendee/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/attendee/add';
        }
        setcookie("postarray", "", time() - 3600);
        $arrData['fileUpload'] = TRUE;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves entire information of attendee
     * 
     * @author  Rohan
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAll($data, $id = NULL) {
        //echo '<pre>'; print_r($data);  exit;
        $error = FALSE;
        if (!is_null($id))
            $arrResult = $this->getAll($id, TRUE);
        //  echo '<pre>'; print_r($arrResult);
        //echo "<br>";
        // echo "######".$id;
        // echo "<br>";
        // echo "****".$arrResult->user_id;
        // exit;
        try {
            if ($arrResult->spk_ex_type == 'exhibitor') {
                $data['attendee_type'] = 'E';
            }

            $data['type_of_user'] = 'A';
            if (is_null($id)) {
                //echo "in if";
                $user_id = $this->user_model->save($data, $id);
            } else
                $user_id = $this->user_model->save($data, $arrResult->user_id);
            $data['user_id'] = $user_id;

//echo '<pre>'; print_r($data);
//exit;
            $data['industry'] = $data['industry_id'];
            $data['functionality'] = $data['functionality_id'];
            $attendee_id = $this->id = $this->save($data, $id);
            //echo $attendee_id; exit;
            if (isset($data['tag_name'])) {
                $tags = saveTags($data);
                $arrTagId = $this->tag_model->getTagByName($tags);
                $arrTags = array();
                $i = 0;
                foreach ($arrTagId as $tag) {
                    $arrTags[$i]['object_id'] = $attendee_id;
                    $arrTags[$i]['object_type'] = 'attendee';
                    $arrTags[$i]['tag_id'] = $tag['id'];
                    $i++;
                }
                if (!is_null($id)) {
                    if (!$this->tag_relation_model->delete('attendee', $id))
                        $error = TRUE;
                }
                $this->tag_relation_model->save_batch($arrTags);
            }

//echo '<pre>'; print_r($data); exit;
//            if (isset($data['industry_id'])) {
//                $arrTags = array();
//                foreach ($data['industry_id'] as $industry) {
//                    $arrTags[$i]['attendee_id'] = $attendee_id;
//                    $arrTags[$i]['industry_id'] = $industry;
//                    $i++;
//                }
//                $this->has_model->tableName = 'attendee_has_industry';
//                if (!is_null($id)) {
//                    $arrHasDelete = array("attendee_id" => $id);
//
//                    if (!$this->has_model->delete($arrHasDelete))
//                        $error = TRUE;
//                }
//                $this->has_model->save($arrTags);
//            }
//            if (isset($data['functionality_id'])) {
//                $arrTags = array();
//                foreach ($data['functionality_id'] as $industry) {
//                    $arrTags[$i]['attendee_id'] = $attendee_id;
//                    $arrTags[$i]['functionality_id'] = $industry;
//                    $i++;
//                }
//                $this->has_model->tableName = 'attendee_has_functionality';
//                if (!is_null($id)) {
//                    $arrHasDelete = array("attendee_id" => $id);
//
//                    if (!$this->has_model->delete($arrHasDelete))
//                        $error = TRUE;
//                }
//                $this->has_model->save($arrTags);
//            }

            if (is_null($id)) {
                $arrHasCode = array();
                $arrHasCode['attendee_id'] = $attendee_id;
                $arrHasCode['event_id'] = $data['event_id'];
                $arrHasCode['passcode'] = generatePassword(6);
                $arrHasCode['status'] = 0;

                $this->has_model->tableName = 'event_has_attendee';
                $this->has_model->saveSingle($arrHasCode);
            } else {

                $arrHasCode = array();
                $arrHasCode['attendee_id'] = $attendee_id;
                $arrHasCode['event_id'] = $data['event_id'];
                $arrHasCode['passcode'] = generatePassword(6);
                $arrHasCode['status'] = 1;
                //echo '<pre>'; print_r($arrHasCode); exit;
                $this->has_model->tableName = 'event_has_attendee';
                $delete_data['attendee_id'] = $attendee_id;
                $this->has_model->delete($delete_data);
                $this->has_model->saveSingle($arrHasCode);
            }
        } catch (Exception $e) {
            $error = true;
        }
        if ($error) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * save
     *
     * saves attendee
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function save($data, $id = NULL) {
//print_r($data);
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
        //print_r($arrData);  exit;
        if (!isset($arrData['status']))
            $arrData['status'] = 1;
        // echo "bhavana";  print_r($arrData['attendee_type']); 
        if (!isset($arrData['attendee_type']) && is_null($id))
            $arrData['attendee_type'] = 'A';


        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();
            $result = $this->db->insert('attendee', $arrData);
            $id = $this->db->insert_id();
            //echo $this->db->last_query(); exit;
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('attendee', $arrData);
            //var_dump($result);
            //echo $this->db->last_query(); exit;
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

    /* function save_in_other_table($data, $attendee_id) {
      foreach($data as $key=>$value){
      if(in_array($key, $this->fields))
      $arrData[$key] = (isset($data[$key]))?$data[$key]:'';
      print_r($arrData);exit;
      }
      }
     */

    /**
     * get
     *
     * gets attendee
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

        if ($row) {
            $result = $this->db->get('attendee')->row();

            return $result;
        } else {
            $result = $this->db->get('attendee');

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
        if (!is_null($id) && $where == 'attendee.id')
            $this->db->select('A_T.industry as industry_id,
                               A_T.functionality as functionality_id'
//                    '(select group_concat(attendee_has_industry.industry_id) from attendee_has_industry where attendee_id = ' . $id . ') as industry_id   
//        ,(select group_concat(attendee_has_functionality.functionality_id) from attendee_has_functionality where attendee_id = ' . $id . ') as functionality_id,   
//        '
                    , false);
        $this->db->select('attendee.id as attendee_id,user.id as user_id,attendee.*,user.*');
        $this->db->select('event.name as event_name,event.paid_event as event_paid_status,organizer.id as organizer_id,organizer.name as organizer_name,event.id as event_id,event_has_attendee.passcode,event_has_attendee.status as attendee_status,event_has_attendee.approve_by_org as attendee_approve_status,event_has_attendee.mail_sent as event_mail_sent');
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
                    if (!empty($drop_down_search)) {
                        $this->db->where("event_has_attendee.event_id", $drop_down_search);
                    }
                } else if ($type = 'or') {
                    $this->db->or_where($field, $search);
                }
            }
        }

        if (!is_null($id)) {
            $this->db->select('(select group_concat(tag_name) as tag from tag
            INNER JOIN tag_relation ON tag_relation.tag_id = tag.id
            where object_id = ' . $id . ' AND object_type="attendee") as tag_name ', false);
        }

        $this->db->where_in('attendee_type', $this->attendee_type);

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
     * gets all Attendee
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
                    $imgfile = UPLOAD_ATTENDEE_PHOTO_DISPLAY . $this->upload->file_name;
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
     * @author  Rohan
     * @access  public
     * @param array $arrData,Integer $id
     * @return  array
     */
    function delete($arrData) {
        $this->db->where_in('id', $arrData);
        if ($this->db->delete('attendee')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check_attendee
     *
     * checks if attendee exist
     * 
     * @author  Aatsih 
     * @access  public
     * @params  array $data 
     * @params  $email
     * @return  void
     */
    function check_attendee($where = array()) {
//        $this->db->select('id');
//        display($where);

        $this->db->select('attendee.id as attendee_id,attendee.*,user.*');
        if (isset($where['first_name']) && isset($where['last_name']) && isset($where['email'])) {
            $first_name = $where['first_name'];
            $last_name = $where['last_name'];
            $email = $where['email'];
            $this->db->where('first_name', $first_name);
            $this->db->where('last_name', $last_name);
            $this->db->or_where('email', $email);
        } else {
            $this->db->where($where);
        }
//        $this->db->where($where);

        $this->db->join('user', 'user.id = attendee.user_id');

        $result = $this->db->get('attendee')->row();
//        show_query();
//        display($result);
//        $this->db->where($field . ' IS NOT NULL');

        if ($result) {
            return $result->attendee_id;
        } else {
            return FALSE;
        }
    }

    /**
     * saveAll
     *
     * saves entire information of attendee
     * 
     * @author  Rohan
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAllOverwrite($data, $id = NULL) {
        $error = FALSE;
        try {

//            $this->db->trans_begin();

            if (!is_null($id)) {
                $arrResult = $this->get($id, TRUE);
//                echo '';print_r($arrResult);exit;
                if (isset($arrResult->id))
                    $id = $arrResult->id;
                else
                    $id = NULL;
            }

            $data['type_of_user'] = 'A';
            if (!is_null($id))
                $user_id = $this->user_model->save($data, $arrResult->user_id);
            else
                $user_id = $this->user_model->save($data);

            $data['user_id'] = $user_id;
//            echo '<pre>';print_r($data);exit;
            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];

           
            if (isset($data['industry_id'])) {
                $arrTags = array();
                foreach ($data['industry_id'] as $industry) {
                    $data['industry'] = $industry;
                }
            }
            if (isset($data['functionality_id'])) {
                $arrTags = array();
                foreach ($data['functionality_id'] as $industry) {
                    $data['functionality'] = $industry;
                }
            }
            $attendee_id = $this->save($data, $id);


            $i = 0;
            if (!is_null($id)) {
                if (!$this->tag_relation_model->delete('attendee', $id))
                    $error = TRUE;
            }
            if (isset($data['tag_name'])) {
                $tags = saveTags($data);
                $arrTagId = $this->tag_model->getTagByName($tags);
                $arrTags = array();
                $i = 0;
                foreach ($arrTagId as $tag) {
                    $arrTags[$i]['object_id'] = $attendee_id;
                    $arrTags[$i]['object_type'] = 'attendee';
                    $arrTags[$i]['tag_id'] = $tag['id'];
                    $i++;
                }

                $this->tag_relation_model->save_batch($arrTags);
            }
//            $this->has_model->tableName = 'attendee_has_industry';
//            if (!is_null($id)) {
//                $arrHasDelete = array("attendee_id" => $id);
//
//                if (!$this->has_model->delete($arrHasDelete))
//                    $error = TRUE;
//            }
//            if (isset($data['industry_id'])) {
//                $arrTags = array();
//                foreach ($data['industry_id'] as $industry) {
//                    $arrTags[$i]['attendee_id'] = $attendee_id;
//                    $arrTags[$i]['industry_id'] = $industry;
//                    $i++;
//                }
//
//                $this->has_model->save($arrTags);
//            }
//            $this->has_model->tableName = 'attendee_has_functionality';
//            if (!is_null($id)) {
//                $arrHasDelete = array("attendee_id" => $id);
//
//                if (!$this->has_model->delete($arrHasDelete))
//                    $error = TRUE;
//            }
            if (isset($data['functionality_id'])) {
//                $arrTags = array();
//                foreach ($data['functionality_id'] as $industry) {
//                    $arrTags[$i]['attendee_id'] = $attendee_id;
//                    $arrTags[$i]['functionality_id'] = $industry;
//                    $i++;
//                }
//
//                $this->has_model->save($arrTags);
                $this->has_model->tableName = 'event_has_attendee';
                $arrHasDelete = array("attendee_id" => $attendee_id, "event_id" => $this->event_id);

                if (!$this->has_model->delete($arrHasDelete))
                    $error = TRUE;
                $arrHasCode = array();
                $arrHasCode['attendee_id'] = $attendee_id;
                $arrHasCode['event_id'] = $this->event_id;
                $arrHasCode['passcode'] = generatePassword(6);
                $arrHasCode['status'] = 0;
//                print_r($arrHasCode);
                $this->has_model->tableName = 'event_has_attendee';
                $this->has_model->saveSingle($arrHasCode);
            }
        } catch (Exception $e) {
            $error = true;
        }
        if ($error) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function sendPasscode($data = array()) {
        //echo '1541';exit;
        $this->load->helper('admin_emailer');
        $this->load->model('notification_model');
        if (empty($data))
            return false;
        $status = true;
        $count = 0;
        foreach ($data as $id) {

            $arrEmail = $this->getEmailAndPassCode($id);
            //echo '<pre>'; print_r($arrEmail); exit;
            if (is_array($arrEmail)) {
                $to = $arrEmail[0]['email'];
                $objAttend = $this->getAll($id, true);
                $selected_event = $objAttend->event_id;
                if ($this->session->userdata('selected_event')) {
                    $selected_event = $this->session->userdata('selected_event');
                }
//                echo '<pre>';
//                print_r($selected_event);
//                print_r($objAttend);
//                print_r("cv" . $id);
//                exit;

                $arrSave = array();
                $arrInsert = array();
                #notification content 
                //$arrInsert['content'] = 'Your Passcode for the ' . $objAttend->event_name . ' event is >' . $objAttend->passcode . '.';
                $arrInsert['content'] = $objAttend->passcode;
                $arrInsert['status'] = 1;
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrInsert['display_time'] = date("Y-m-d H:i:s");
                $arrInsert['type'] = 'Passcode';
                $arrInsert['event_id'] = $objAttend->event_id;
                $arrInsert['object_id'] = $objAttend->event_id;
                $arrInsert['object_type'] = 'O';
                $arrInsert['subject_id'] = $objAttend->attendee_id;
                $arrInsert['subject_type'] = 'A';
                $arrSave[] = $arrInsert;
                $status = $this->notification_model->save($arrSave);

                //MAIL TEMLATE***
                $email_template = get_email_template('passcode_to_attendee_speaker');
                $keywords = array('{app_name}', '{event_name}', '{duration}', '{address}', '{first_name}', '{passcode}', '{password}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
                $replace_with = array(
                    $email_template['setting']['app_name'],
                    $objAttend->event_name,
                    date('Y-m-d', strtotime($objAttend->event_start)) . " To " . date('Y-m-d', strtotime($objAttend->event_end)),
                    $objAttend->event_location . ',' . $objAttend->event_city . ',' . $objAttend->event_country,
                    $objAttend->first_name,
                    $objAttend->passcode,
                    '12345',
                    $email_template['setting']['app_contact_email'],
                    SITE_URL,
                    CLIENT_IMAGES,
                    '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                );
//                echo $objAttend->passcode; die;
                $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                $html = str_replace($keywords, $replace_with, $email_template['body']);
                //MAIL TEMLATE CLOSE***
                //if($objAttend->subscribe_email == 1) {
                if (isset($objAttend->subscribe_email)) {
                    //$to = 'rohanbpatil77@gmail.com';
                    sendMail($to, $subject, '', $html);
                    $count++;
                    $this->db->where('event_id', $selected_event);
                    $this->db->where('attendee_id', $objAttend->attendee_id);
                    $arrData = array('approve_by_org' => 1, 'mail_sent' => 1);
                    $this->db->update('event_has_attendee', $arrData);
                    $arrData['mail_sent'] = 1;
                    $this->save($arrData, $id);
                }
            } else {
                $status = false;
            }
        }
        //echo '<br>'.$count; 
        //exit;
        return $status;
//        die('adf');
    }

    function by_pass_passcode($data = array()) {
        //echo '1541';exit;
//        $this->load->model('event_has_attendee');
        $this->load->model('attendee_model');
        if (empty($data))
            return false;
        $status = true;
        $count = 0;
        foreach ($data as $id) {

            $objAttend = $this->getAll($id, true);
//            show_query();
//            display($id);
            $selected_event = $objAttend->event_id;
            if ($this->session->userdata('selected_event')) {
                $selected_event = $this->session->userdata('selected_event');
            }
            //if($objAttend->subscribe_email == 1) {
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
        //echo '<br>'.$count; 
        //exit;
        return $status;
//        die('adf');
    }

    function

    getEmailAndPassCode($id = NULL) {
        if (is_null($id))
            return
                    false;


        $this->db->select('user.email,event_has_attendee.passcode,attendee.name as attendee_name,event.name as event_name');
        $this->db->where('attendee.id', $id);
        if ($this->event_id != '')
            $this->db->where('event_has_attendee.event_id', $this->event_id);
        $this->db->join('user', 'attendee.user_id = user.id');

        $this->db->join('event_has_attendee', 'event_has_attendee.attendee_id = attendee.id');
        $this->db->join('event', 'event_has_attendee.event_id = event.id');
        $result = $this->db->get('attendee');
//        echo $this->db->last_query();
        return $result->result_array();
    }

    /**
     * getDropdownValues
     *
     * gets event dropdown values
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function

    getDropdownValues($id = NULL, $first = false) {
        $dropDownValues = $this->getAll();
//       echo '<pre>'; print_r($dropDownValues);exit;
        $arrDropdown = array();
        if ($first)
            $arrDropdown[] = 'Select Event';


        foreach ($dropDownValues as $value) {

            $arrDropdown[$value['attendee_id']] = $value['first_name'] . ' ' . $value ['last_name'];
        }
        return $arrDropdown;
    }

}

?>
