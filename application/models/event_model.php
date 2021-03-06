<?php

class event_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    // $date = strtotime($arrResult->event_start);
    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $event_id;
    public $order_name = 'event.id';
    public $fields = array(
        "id",
        "name",
        "description",
        "event_start",
        "event_end",
        "paid_event",
        "paymnet_type",
        "payment_url",
        "event_cost",
        "is_featured",
        "status",
        "created_by",
        "created_date",
        "pvt_org_id",
        "organizer_id"
    );

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

        $arrResult = array();
        if (!is_null($id)) {
            $arrResult = $this->getAll($id, TRUE);
//            echo '<pre>';            print_r($arrResult->paymnet_type);            die;
//            echo set_value('paid_event', (isset($arrResult->paid_event) ? $arrResult->paid_event : (isset($postarray['paid_event']) ? $postarray['paid_event'] : '')));
//            die;
            if ($arrResult->logo == '') {
                unset($arrResult->logo);
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

            if ($arrResult->image3 == '') {
                unset($arrResult->image3);
            }
        }
        //  echo '<pre>';print_r($arrResult);exit;
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
            $logo = '<img src="' . base_url() . UPLOAD_EVENT_LOGO_DISPLAY . $arrResult->logo . '" alt="logo">';
        } else {
            $logo = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->floor_plan)) {
            $floar_plan = '<img src="' . base_url() . UPLOAD_EVENT_FLOORPLAN_DISPLAY . $arrResult->floor_plan . '" alt="floar_plan">';
        } else {
            $floar_plan = '<img src="http://placehold.it/106x64" alt="floar_plan">';
        }

        if (isset($arrResult->image1)) {
            $image1 = '<img src="' . base_url() . UPLOAD_EVENT_IMAGES_DISPLAY . $arrResult->image1 . '" alt="logo">';
        } else {
            $image1 = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->image2)) {
            $image2 = '<img src="' . base_url() . UPLOAD_EVENT_IMAGES_DISPLAY . $arrResult->image2 . '" alt="logo">';
        } else {
            $image2 = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->image3)) {
            $image3 = '<img src="' . base_url() . UPLOAD_EVENT_IMAGES_DISPLAY . $arrResult->image3 . '" alt="logo">';
        } else {
            $image3 = '<img src="http://placehold.it/106x64" alt="">';
        }


        //  echo '<pre>';print_r($arrResult);exit;
        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'organizer' => array("name" => "organizer_id",
                "type" => "dropdown",
                "id" => "organizer_id",
                "class" => "form-control chosen-select ",
                "placeholder" => "Organizer",
                "options" => $this->organizer_model->getDropdownValues(),
                "validate" => 'required',
                "error" => 'Organizer',
                "value" => set_value('organizer_id', (isset($arrResult->organizer_id) ? $arrResult->organizer_id : (isset($postarray['organizer_id']) ? $postarray['organizer_id'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Organizer Name </div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'is_featured' => array(
                "name" => "is_featured",
                "type" => "dropdown",
                "id" => "is_featured",
                "class" => "form-control chosen-select ",
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
                        "class" => "col-sm-3"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Is Featured</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control validate[required]",
                "placeholder" => "Event Name*",
                "validate" => 'required|trim|is_unique[event.name]',
                "error" => 'Name',
                "value" => set_value('name', (isset($arrResult->name) ? $arrResult->name : (isset($postarray['name']) ? $postarray['name'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event Name <span class="field_required">*</span> </div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
//            'tag' => array("name" => "tag_name",
//                "type" => "text",
//                "id" => "tags",
//                "class" => "form-control ",
//                "placeholder" => "Tag",
//                "validate" => '',
//                "error" => 'Tag',
//                "value" => set_value('tag_name', (isset($arrResult->tag) ? '' : (isset($postarray['tag_name']) ? $postarray['tag_name'] : ''))),
//                "decorators" => array(
//                    array(
//                        "tag" => "div",
//                        "close" => "true",
//                        "class" => "col-sm-6"
//                    ),
//                    array(
//                        "tag" => "label",
//                        "close" => "false",
//                        "class" => "col-sm-1 control-label form-label-placeholder",
//                        "content" => '<div>Tag</div>',
//                        "position" => "prependElement",
//                    ),
//                    array("tag" => "div",
//                        "close" => "close",
//                    ),
//                ),
//            ),
            'paid_event' => array("name" => "paid_event",
                "type" => "dropdown",
                "id" => "paid_event",
                "class" => "form-control paid_event chosen-select",
                "placeholder" => "Paid Event",
                "options" => array("0" => "Free Registration", "1" => "Paid Event"),
                "validate" => '',
                "error" => 'paid_event',
                "value" => set_value('paid_event', (isset($arrResult->paid_event) ? $arrResult->paid_event : (isset($postarray['paid_event']) ? $postarray['paid_event'] : 0))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "control-label",
                        "content" => '<div>Free or Paid?</div>',
                        "position" => "prependElement",
                    ),
//                    array("tag" => "div",
//                        "close" => "close",
//                    ),
                ),
            ),
            'payment_type' => array("name" => "payment_type",
                "type" => "dropdown",
//                "id" => "",
                "class" => "form-control payment_type chosen-select",
//               "placeholder" => array('0' => "On procialize", '1' => "On Organizer Website"),
                "options" => array('0' => getSetting()->app_name . " Payment Gateway", '1' => "Direct Users to Organizer's Payment Gateway"),
                "validate" => '',
                "error" => 'payment_type',
                "value" => set_value('payment_type', (isset($arrResult->payment_type) ? $arrResult->payment_type : (isset($postarray['payment_type']) ? $postarray['payment_type'] : 0))),
                "decorators" => array(
//                    array(
//                        "tag" => "div",
//                        "close" => "false",
//                        "class" => "form-group",
//                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3 paymnt_type_class"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "control-label",
                        "content" => '<div>Payment Type</div>',
                        "position" => "prependElement",
                    ),
//                    array("tag" => "div",
//                        "close" => "close",
//                    ),
                ),
            ),
            'event_cost' => array("name" => "event_cost",
                "type" => "text",
                "id" => "event_cost",
                "class" => "form-control ",
                "placeholder" => "Event Registration Fees",
                "validate" => '',
                "error" => 'event_cost',
                "value" => set_value('event_cost', (isset($arrResult->event_cost) ? $arrResult->event_cost : (isset($postarray['event_cost']) ? $postarray['event_cost'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3 event_cost"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event Registration Fees</div>',
                        "position" => "prependElement",
                    ),
//                    array("tag" => "div",
//                        "close" => "close",
//                    ),
                ),
            ),
            'payment_url' => array("name" => "payment_url",
                "type" => "text",
                "id" => "payment_url",
                "class" => "form-control ",
                "placeholder" => "Payment URL",
                "validate" => '',
                "error" => 'payment_url',
                "value" => set_value('payment_url', (isset($arrResult->payment_url) ? $arrResult->payment_url : (isset($postarray['payment_url']) ? $postarray['payment_url'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3 payment_url"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Payment URL</div>',
                        "position" => "prependElement",
                    ),
//                    array("tag" => "div",
//                        "close" => "close",
//                    ),
                ),
            ),
            'description' => array("name" => "description",
                "type" => "textarea",
                "id" => "description",
                "class" => "form-control",
                "maxlength" => "100",
                "placeholder" => "Event Description (Maximum 100 words)",
                "rows" => '5',
                "validate" => '',
                // 'content'=>'<textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="10"></textarea>',
                "error" => 'Event Description',
                "value" => set_value('description', (isset($arrResult->description) ? $arrResult->description : (isset($postarray['description']) ? $postarray['description'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-12"
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Description</div>',
                        "position" => "prependElement",
                    ),
                /* array(
                  "tag" => "div",
                  "close" => "true",
                  "class" => '',
                  'tag_data' => '<textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="5"></textarea>',
                  ), */
                ),
            ),
            'event_start' => array("name" => "event_start",
                "type" => "text",
                "id" => "event_start",
                "readonly" => '',
                "class" => "form-control validate[required]",
                "placeholder" => "Event Start Date*",
                "validate" => 'required',
                "error" => 'Event Start',
                //date('d-F-Y', strtotime($arrResult->event_start))
                "value" => set_value('event_start', (isset($arrResult->event_start) ? date('m/d/Y', strtotime($arrResult->event_start)) : (isset($postarray['event_start']) ? $postarray['event_start'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event Start Date<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'event_end' => array("name" => "event_end",
                "type" => "text",
                "id" => "event_end",
                "readonly" => '',
                "class" => "form-control validate[required]",
                "placeholder" => "Event End Date*",
                "validate" => 'required',
                "error" => 'Event End',
                "value" => set_value('event_end', (isset($arrResult->event_end) ? date('m/d/Y', strtotime($arrResult->event_end)) : (isset($postarray['event_end']) ? $postarray['event_end'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event End Date<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'industry' => array("name" => "industry_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "class" => "form-control chosen-select validate[required]",
                "placeholder" => "Select Industry*",
                "validate" => 'required|trim',
                "error" => 'Industry',
                "attributes" => ' multiple id="industry_id"  data-placeholder="Select Industry"',
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Select Industry<span class="field_required">*</span></div>',
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
                "placeholder" => 'Event Start Date<span class="field_required">*</span></div>',
                "options" => $this->functionality_model->getDropdownValues(),
                "validate" => 'required|trim',
                "error" => 'Functionality',
                "attributes" => ' multiple id="functionality_id"   data-placeholder="Select Functionality"',
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Select Functionality<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'website_link' => array("name" => "website",
                "type" => "text",
                "id" => "website_link",
                "class" => "form-control",
                "placeholder" => "Event Website Link",
                "validate" => '',
                "error" => 'Website Link',
                "value" => set_value('website_link', (isset($arrResult->website) ? $arrResult->website : (isset($postarray['website']) ? $postarray['website'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event Website Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'facebook_link' => array("name" => "facebook",
                "type" => "text",
                "id" => "facebook",
                "class" => "form-control ",
                "placeholder" => "Event Facebook Handle",
                "validate" => '',
                "error" => 'Facebook Link',
                "value" => set_value('facebook', (isset($arrResult->facebook) ? $arrResult->facebook : (isset($postarray['facebook']) ? $postarray['facebook'] : ''))),
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
                        "content" => '<div>Event Facebook Handle</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'twitter_link' => array("name" => "twitter",
                "type" => "text",
                "id" => "twitter",
                "class" => "form-control",
                "placeholder" => "Event Twitter Handle",
                "validate" => '',
                "error" => 'Twitter Link',
                "value" => set_value('twitter', (isset($arrResult->twitter) ? $arrResult->twitter : (isset($postarray['twitter']) ? $postarray['twitter'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div  style="width: 108%;">Event Twitter Handle ( no need to proceed by @ )</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'linkedin_link' => array("name" => "linkden",
                "type" => "text",
                "id" => "linkden",
                "class" => "form-control",
                "placeholder" => "Event Linkedin Link",
                "validate" => '',
                "error" => 'Linkedin Link',
                "value" => set_value('linkedin', (isset($arrResult->linkden) ? $arrResult->linkden : (isset($postarray['linkden']) ? $postarray['linkden'] : ''))),
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
                        "content" => '<div>Event Linkedin Link</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'country' => array("name" => "country",
                "type" => "text",
                "id" => "country",
                "class" => "form-control validate[required]",
                "placeholder" => "Event Country*",
                "validate" => 'required|trim',
                "error" => ' Event Country*',
                "value" => set_value('country', (isset($arrResult->country) ? $arrResult->country : (isset($postarray['country']) ? $postarray['country'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event Country<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'city' => array("name" => "city",
                "type" => "text",
                "id" => "city",
                "class" => "form-control validate[required]",
                "placeholder" => "Event City*",
                "validate" => 'required|trim',
                "error" => 'City',
                "value" => set_value('twitter', (isset($arrResult->city) ? $arrResult->city : (isset($postarray['city']) ? $postarray['city'] : ''))),
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
                        "content" => '<div>Event City<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'location' => array("name" => "location",
                "type" => "text",
                "id" => "location_google",
                "class" => "form-control validate[required]",
                "placeholder" => "Event Venue Address (Detailed Address)*",
                "validate" => 'required',
                "error" => 'Location',
                "value" => set_value('location', (isset($arrResult->location) ? $arrResult->location : (isset($postarray['location']) ? $postarray['location'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Event Venue Address (Detailed Address)<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            //bhavana ********************* 
            'logo' => array(
                "name" => "logo",
                "type" => "file",
                "id" => "logo",
                "class" => "form-control",
                "placeholder" => "Logo",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EVENT_LOGO_DISPLAY,
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail event_logo_image" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $logo . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Logo*<br>(180px x 180px)</span><span class="fileinput-exists">Change Logo</span>',
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
            'floor_plan' => array(
                "name" => "floor_plan",
                "type" => "file",
                "id" => "floor_plan",
                "class" => "form-control ",
                "placeholder" => "Floor Plan",
                "upload_config" => array(
                    "upload_path" => UPLOAD_EVENT_FLOORPLAN_DISPLAY,
                    "allowed_types" => 'jpg|png|jpeg|pdf|doc|docx',
                    "max_size" => '3072',
                ),
                "error" => 'Floor Plan',
                "validate" => '',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $floar_plan . '</div>'
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
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Event Floor Plan</span><span class="fileinput-exists">Change Floor Plan</span>',
                    ),
                ),
            ),
            'image1' => array(
                "name" => "image1",
                "type" => "file",
                "id" => "image1",
                "class" => "form-control",
                "placeholder" => "Image",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EVENT_IMAGES,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Image 1',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail event_logo_image1" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image1 . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Image 1<br>(180px x 180px)</span><span class="fileinput-exists">Change Image 1</span>',
                    ),
                ),
            ),
            'image2' => array(
                "name" => "image2",
                "type" => "file",
                "id" => "image2",
                "class" => "form-control",
                "placeholder" => "Image 2",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EVENT_IMAGES,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Image 1',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail event_logo_image2" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image2 . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Image 2<br>(180px x 180px)</span><span class="fileinput-exists">Change Image 2</span>',
                    ),
                ),
            ),
            'image3' => array(
                "name" => "image3",
                "type" => "file",
                "id" => "image3",
                "class" => "form-control",
                "placeholder" => "Image 3",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EVENT_IMAGES,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Image 1',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail event_logo_image3" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image3 . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Image 3<br>(180px x 180px)</span><span class="fileinput-exists">Change Image 3</span>',
                    ),
                ),
            ),
            // bhavana end 
            'latitude' => array(
                "type" => "hidden",
                "latitude" => set_value('latitude', (isset($arrResult->latitude) ? $arrResult->latitude : '')),
            ),
            'longitude' => array(
                "type" => "hidden",
                "longitude" => set_value('longitude', (isset($arrResult->longitude) ? $arrResult->longitude : '')),
            ),
            'first_name' => array("name" => "contact_name",
                "type" => "text",
                "id" => "contact_name",
                "class" => "form-control validate[required]",
                "placeholder" => "Contact Person's First Name*",
                "validate" => 'required',
                "error" => 'Contact Person\'s Name',
                "value" => set_value('contact_name', (isset($arrResult->contact_name) ? $arrResult->contact_name : (isset($postarray['contact_name']) ? $postarray['contact_name'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Contact Persons First Name <span class="field_required">*</span></div>',
                        "position" => "prependElement",
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
            'last_name' => array("name" => "contact_lastname",
                "type" => "text",
                "id" => "contact_lastname",
                "class" => "form-control",
                "placeholder" => "Contact Person's Last Name",
                "validate" => '',
                "error" => 'Contact Person\'s Name',
                "value" => set_value('contact_name', (isset($arrResult->contact_lastname) ? $arrResult->contact_lastname : (isset($postarray['contact_lastname']) ? $postarray['contact_lastname'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Contact Persons Last Name</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'phone' => array("name" => "contact_mobile",
                "type" => "text",
                "id" => "mobile",
                "class" => "form-control validate[custom[phone]]",
                "placeholder" => "Mobile Number*",
                "validate" => 'regex_match[/^[\d\-\+\s]+$/]',
                "error" => 'Mobile Number',
                "value" => set_value('phone', (isset($arrResult->contact_mobile) ? $arrResult->contact_mobile : (isset($postarray['contact_mobile']) ? $postarray['contact_mobile'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Mobile Number <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            // bhavana
            'Telephone' => array("name" => "contact_phone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control validate[custom[phone]]",
                "placeholder" => "Telephone Number",
                "validate" => 'regex_match[/^[\d\-\+\s]+$/]',
                "error" => 'Telephone Number',
                "value" => set_value('phone', (isset($arrResult->contact_phone) ? $arrResult->contact_phone : (isset($postarray['contact_phone']) ? $postarray['contact_phone'] : ''))),
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
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Telephone Number </div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'email' => array("name" => "contact_email",
                "type" => "text",
                "id" => "email",
                "class" => "form-control validate[required,custom[email]]",
                "placeholder" => "Contact Email ID*",
                "validate" => 'required',
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
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Contact Email ID <span class="field_required">*</span> </div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            // bhavana
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
                "value" => set_value('status', (isset($arrResult->status) ? $arrResult->status : (isset($postarray['status']) ? $postarray['status'] : ''))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-4"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "label",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Status </div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
        );

        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/event/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/event/add';
        }
        setcookie("postarray", "", time() - 3600);
        unset($postarray);
        $arrData['fileUpload'] = true;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        //	var_dump($arrData);
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves entire information of event
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
            if (isset($data['industry_id'])) {
                foreach ($data['industry_id'] as $industry) {
                    $data['industry'] = $industry;
                }
            }
            if (isset($data['functionality_id'])) {
                foreach ($data['functionality_id'] as $industry) {
                    $data['functionality'] = $industry;
                }
            }
            $this->db->trans_begin();
            $event_id = $this->save($data, $id);
            $data['event_id'] = $event_id;

            $this->event_profile_model->save($data, $id);
            if (isset($data['tag_name'])) {
                $tags = saveTags($data);
                $arrTagId = $this->tag_model->getTagByName($tags);
                $arrTags = array();
                $i = 0;
                foreach ($arrTagId as $tag) {
                    $arrTags[$i]['object_id'] = $event_id;
                    $arrTags[$i]['object_type'] = 'event';
                    $arrTags[$i]['tag_id'] = $tag['id'];
                    $i++;
                }
                if (!is_null($id)) {
                    if (!$this->tag_relation_model->delete('event', $id))
                        $error = TRUE;
                }
                $this->tag_relation_model->save_batch($arrTags);
            }
//            if (isset($data['industry_id'])) {
//                $arrTags = array();
//                foreach ($data['industry_id'] as $industry) {
//                    $arrTags[$i]['event_id'] = $event_id;
//                    $arrTags[$i]['industry_id'] = $industry;
//                    $i++;
//                }
//                $this->has_model->tableName = 'event_has_industry';
//                if (!is_null($id)) {
//                    $arrHasDelete = array("event_id" => $id);
//                    if (!$this->has_model->delete($arrHasDelete))
//                        $error = TRUE;
//                }
//                $this->has_model->save($arrTags);
//            }
//            if (isset($data['functionality_id'])) {
//                $arrTags = array();
//                foreach ($data['functionality_id'] as $industry) {
//                    $arrTags[$i]['event_id'] = $event_id;
//                    $arrTags[$i]['functionality_id'] = $industry;
//                    $i++;
//                }
//                $this->has_model->tableName = 'event_has_functionality';
//                if (!is_null($id)) {
//                    $arrHasDelete = array("event_id" => $id);
//
//                    if (!$this->has_model->delete($arrHasDelete))
//                        $error = TRUE;
//                }
//                $this->has_model->save($arrTags);
//            }
        } catch (Exception $e) {
            $error = true;
        }
        if ($error) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return !$error;
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
        if (isset($arrData['event_start'])) {
            $date_start = date('Y-m-d h:i:s', strtotime($arrData['event_start']));
        }
        if (isset($arrData['event_end'])) {
            $date_end = date('Y-m-d h:i:s', strtotime($arrData['event_end']));
        }



        if (is_null($id)) {
            $arrData['event_start'] = $date_start;
            $arrData['event_end'] = $date_end;
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();
            $result = $this->db->insert('event', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['event_start'] = $date_start;
            $arrData['event_end'] = $date_end;
            //  print_r($arrData['event_end']); exit;
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            // echo '<pre>'; print_r($arrData); exit;
            $this->db->where('id', $id);
            $result = $this->db->update('event', $arrData);
            // print_r($result); exit;
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
     * gets events
     * 
     * @author  Aatish Gore
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
            $result = $this->db->get('event')->row();

            return $result;
        } else {
            $result = $this->db->get('event');

            return $result->result_array();
        }
    }

    /**
     * getAll
     *
     * gets all events
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $type = 'LIKE') {

        if (!is_null($id))
            $this->db->where('event.id', $id);
        if (!is_null($id)) {
            $this->db->select('event.industry as industry_id,
                              event.functionality as functionality_id'
//                    (select group_concat(event_has_industry.industry_id) from event_has_industry where event_id = ' . $id . ') as industry_id   
//        ,(select group_concat(event_has_functionality.functionality_id) from event_has_functionality where event_id = ' . $id . ') as functionality_id,   
                    , false);
        }

        $this->db->select('event.*,event.id as event_id,event_profile.*, organizer.name as organizer_name');

        if (!is_null($id)) {
            $this->db->select('(select group_concat(tag_name) as tag from tag
            INNER JOIN tag_relation ON tag_relation.tag_id = tag.id
            where object_id = ' . $id . ' AND object_type="event") as tag_name   
        
        ', false);
        }
        $this->db->join('organizer', 'event.organizer_id = organizer.id');
        if ($search == 'NULL') {
            $this->db->order_by('event.created_date', 'desc');
        } else {
            $this->db->order_by($this->order_name, $this->order_by);
        }
        // $this->db->order_by($this->order_name, $this->order_by);
        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                if ($type == 'LIKE') {
                    $where = "$field LIKE '%$search%'";
                    $this->db->or_where($where);
                } else if ($type == 'AND') {

                    $this->db->where($field, $search);
                } else if ($type = 'or') {
                    $this->db->or_where($field, $search);
                }
            }
        }

        $this->db->where_in('event.status', $this->status);
        $this->db->join('event_profile', 'event_profile.event_id = event.id');

        if ($row) {
            $result = $this->db->get('event')->row();

            return $result;
        } else {
            $result = $this->db->get('event');

            return $result->result_array();
        }
    }

    //echo $this->db->last_query();
    /**
     * savePhoto
     *
     * gets all events
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function savePhoto(&$data, $form) {
        $return = true;
        //echo "<pre>"; print_r($form['fields']);
        foreach ($form['fields'] as $element) {
            //echo "<pre>"; print_r($element['name']); 
            if ($element['name'] == 'image1' || $element['name'] == 'image2' || $element['name'] == 'image3') {
                $img_location = UPLOAD_EVENT_IMAGES_DISPLAY;
            } else if ($element['name'] == 'logo') {
                $img_location = UPLOAD_EVENT_LOGO_DISPLAY;
            } else if ($element['name'] == 'floor_plan') {
                $img_location = UPLOAD_EVENT_FLOORPLAN_DISPLAY;
            }
            //exit;
            if ($element['type'] == 'file' && $_FILES[$element['name']]['name'] != '') {
                $config = $element['upload_config'];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($element['name'])) {

                    $data[] = $this->upload->display_errors();
                    $return = false;
                } else {

                    $data[$element['name']] = $this->upload->file_name;
                    //echo "<pre>" print_r($this->upload->file_name); exit;
                    //return true;
                    //image resize code
                    $img_name = $this->upload->file_name;
                    $imgfile = $img_location . $this->upload->file_name;
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
    function getDropdownValues($id = NULL, $first = false) {
        $superadmin = $this->session->userdata('is_superadmin');
        if (!$superadmin)
            $this->db->where('id', $this->event_id);
        $dropDownValues = $this->get();

        $arrDropdown = array();
        if ($first)
            $arrDropdown[] = 'Select Event';
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['id']] = $value['name'];
        }
        return $arrDropdown;
    }

    function getOrganizerEvent($user_id = NULL, $type = 'Z') {
        $this->db->ar_where = array();
        $this->db->select('event.id as event_id,event.name as name');
        if ($type == 'O') {
            $this->db->join('organizer', 'organizer.id = event.organizer_id');
            $this->db->where('organizer.user_id', $user_id);
        } elseif ($type == 'E') {
            $this->db->join('exhibitor', 'exhibitor.event_id = event.id');
            $this->db->where('exhibitor.user_id', $user_id);
        }

//        $this->db->order_by('event_start', 'DESC');
        $this->db->order_by('event.id', 'ASC');
        $result = $this->db->get('event');

        return $result->result_array();
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
        //echo '<pre>'; print_r($arrData); exit;

        $this->db->where_in('id', $arrData);
        if ($this->db->delete('event')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check_unique
     *
     * Checks uniqueness of event with name
     * 
     * @author  Rohan
     * @access  public
     * @params  company name
     * @params  event id
     * @return  void
     */
    function check_unique($event) {


        $this->db->where('name', $event);
        $result = $this->db->get('event');
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
