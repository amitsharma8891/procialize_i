<?php

class event_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }
	// $date = strtotime($arrResult->event_start);
    public $status = array("1");
    public $order_by = 'ASC';
    public $order_name = 'event.id';
    public $fields = array(
        "id",
        "name",
        "description",
        "event_start",
        "event_end",
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
           if($arrResult->logo == '') {
                unset($arrResult->logo);
            }

            if($arrResult->image1 == '') {
                unset($arrResult->image1);
            }
            if($arrResult->image2 == '') {
                unset($arrResult->image2);
            }

            if($arrResult->image3 == '') {
                unset($arrResult->image3);
            }
        }
       //  echo '<pre>';print_r($arrResult);exit;
        
        if (isset($arrResult->logo)) {
            $logo = '<img src="'.base_url().'uploads/exhibitor/' . $arrResult->logo . '" alt="logo">';
        } else {
            $logo = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->image1)) {
            $image1 = '<img src="'.base_url().'uploads/exhibitor/' . $arrResult->image1 . '" alt="logo">';
        } else {
            $image1 = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->image2)) {
            $image2 = '<img src="'.base_url().'uploads/exhibitor/' . $arrResult->image2 . '" alt="logo">';
        } else {
            $image2 = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->image3)) {
            $image3 = '<img src="'.base_url().'uploads/exhibitor/' . $arrResult->image3 . '" alt="logo">';
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
                "validate" => '',
                "error" => 'Organizer',
                "value" => set_value('organizer_id', (isset($arrResult->organizer_id) ? $arrResult->organizer_id : $this->input->post("organizer_id"))),
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
                "value" => set_value('is_featured', (isset($arrResult->is_featured) ? $arrResult->is_featured : '')),
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
                ),
            ),
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control validate[required,minSize[6]]",
                "placeholder" => "Event Name*",
                "validate" => 'required|trim|is_unique[event.name]',
                "error" => 'Name',
                "value" => set_value('name', (isset($arrResult->name) ? $arrResult->name : $this->input->post("name"))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-3"
                    ),
                ),
            ),
            'tag' => array("name" => "tag_name",
                "type" => "text",
                "id" => "tags",
                "class" => "form-control ",
                "placeholder" => "Tag",
                "validate" => '',
                "error" => 'Tag',
                "value" => set_value('tag_name', (isset($arrResult->tag) ? $arrResult->tag : $this->input->post("tag_name"))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                ),
            ),
			
          'description' => array("name" => "description",
                "tag" => "textarea",
                "id" => "wysiwyg",
			   // "type"=>"text",
			   // "type"=>"description",
                "class" => "form-control",
                "placeholder" => "Event Description (Maximum 200 words)",
				"rows" => '5',
                "validate" => '',
				// 'content'=>'<textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="10"></textarea>',
                "error" => 'Event Description',
                "value" => set_value('description', (isset($arrResult->description) ? $arrResult->description : $this->input->post("description"))),
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
					/*array(
                        "tag" => "div",
                        "close" => "true",
						"class" => '',
                        'tag_data' => '<textarea id="wysiwyg" placeholder="Enter text here..." class="form-control" rows="5"></textarea>',
                    ),*/
                ),
            ),
            'event_start' => array("name" => "event_start",
                "type" => "text",
                "id" => "event_start",
                "readonly" => '',
                "class" => "form-control ",
                "placeholder" => "Event Start Date*",
                "validate" => 'required',
                "error" => 'Event Start',
				//date('d-F-Y', strtotime($arrResult->event_start))
                "value" => set_value('event_start', (isset($arrResult->event_start) ? date('d-F-Y', strtotime($arrResult->event_start)) : $this->input->post("event_start"))),
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
                ),
            ),
            'event_end' => array("name" => "event_end",
                "type" => "text",
                "id" => "event_end",
                "readonly" => '',
                "class" => "form-control ",
                "placeholder" => "Event End Date*",
                "validate" => 'required',
                "error" => 'Event End',
                "value" => set_value('event_end', (isset($arrResult->event_end) ? date('d-F-Y', strtotime($arrResult->event_end)) : $this->input->post("event_end"))),
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
                ),
            ),
            'industry' => array("name" => "industry_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "class" => "form-control chosen-select validate[required]",
                "placeholder" => "Select Industry*",
                "validate" => 'required|trim',
                "error" => 'Industry',
                "attributes" => ' multiple  data-placeholder="Select Industry"',
                "options" => $this->industry_model->getDropdownValues(),
                "value" => set_value('industry_id', (isset($arrResult->industry_id) ? explode(',', $arrResult->industry_id) : '')),
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
                        "content" => '<h3 class="col-sm-12">General Information</h3>',
                        "position" => "prependOuter",
                    ),
                ),
            ),
            'functionality' => array("name" => "functionality_id[]",
                "type" => "dropdown",
                "id" => "functionality_id",
                "class" => "form-control chosen-select validate[required]",
                "placeholder" => "Select Functionality*",
                "options" => $this->functionality_model->getDropdownValues(),
                "validate" => 'required|trim',
                "error" => 'Functionality',
                "attributes" => ' multiple data-placeholder="Select Functionality"',
                "value" => set_value('functionality_id', (isset($arrResult->functionality_id) ? explode(',', $arrResult->functionality_id) : '')),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
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
                "value" => set_value('website_link', (isset($arrResult->website) ? $arrResult->website : $this->input->post("website"))),
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
            'facebook_link' => array("name" => "facebook",
                "type" => "text",
                "id" => "facebook",
                "class" => "form-control ",
                "placeholder" => "Event Facebook Link",
                "validate" => '',
                "error" => 'Facebook Link',
                "value" => set_value('facebook', (isset($arrResult->facebook) ? $arrResult->facebook : $this->input->post("facebook"))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                ),
            ),
            'twitter_link' => array("name" => "twitter",
                "type" => "text",
                "id" => "twitter",
                "class" => "form-control",
                "placeholder" => "Event Twitter Link",
                "validate" => '',
                "error" => 'Twitter Link',
                "value" => set_value('twitter', (isset($arrResult->twitter) ? $arrResult->twitter : $this->input->post("twitter"))),
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
            'linkedin_link' => array("name" => "linkden",
                "type" => "text",
                "id" => "linkden",
                "class" => "form-control",
                "placeholder" => "Event Linkedin Link",
                "validate" => '',
                "error" => 'Linkedin Link',
                "value" => set_value('linkedin', (isset($arrResult->linkden) ? $arrResult->linkden : $this->input->post("linkden"))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
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
                "value" => set_value('country', (isset($arrResult->country) ? $arrResult->country : $this->input->post("country"))),
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
            'city' => array("name" => "city",
                "type" => "text",
                "id" => "city",
                "class" => "form-control validate[required]",
                "placeholder" => "Event City*",
                "validate" => 'required|trim',
                "error" => 'City',
                "value" => set_value('twitter', (isset($arrResult->city) ? $arrResult->city : $this->input->post("city"))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array("tag" => "div",
                        "close" => "close",
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
                "value" => set_value('location', (isset($arrResult->location) ? $arrResult->location : $this->input->post("location"))),
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
            //bhavana ********************* 
            'logo' => array(
                "name" => "logo",
                "type" => "file",
                "id" => "logo",
                "class" => "form-control",
                "placeholder" => "Logo",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $logo . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Logo*</span><span class="fileinput-exists">Change Logo</span>',
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">Upload Information</h3>
                                    <span class="help-block col-sm-12">Uploads must be PDF/ DOC/ DOCX/ JPG/ GIF/ or PNG and smaller than 3MB</span>
                                    ',
                        "position" => "prependOuter",
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
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        "tag_data" => '<span class="fileinput-new">Event Image 1</span><span class="fileinput-exists">Change Image 1</span>',
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
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        "tag_data" => '<span class="fileinput-new">Event Image 2</span><span class="fileinput-exists">Change Image 2</span>',
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
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image3 . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Image 3</span><span class="fileinput-exists">Change Image 3</span>',
                    ),
                ),
            ),
           /* 'image1' => array("name" => "image1",
                "type" => "file",
                "id" => "image1",
                "class" => "form-control",
                "validate" => '',
                "placeholder" => "Image1",
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        "tag_data" => '<span class="fileinput-new">Event Image 1</span><span class="fileinput-exists">Change Image 1</span>',
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
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        "tag_data" => '<span class="fileinput-new">Event Image 2</span><span class="fileinput-exists">Change Image 2</span>',
                    ),
                ),
            ),
            'image3' => array("name" => "image3",
                "type" => "file",
                "id" => "image3",
                "class" => "form-control",
                "validate" => '',
                "placeholder" => "Image3",
                "upload_config" => array(
                    "upload_path" => UPLOAD_EXHIBITOR_LOGO,
                    "allowed_types" => 'gif|jpg|png|jpeg',
                    "max_size" => '3072',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $image3 . '</div>'
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
                        "tag_data" => '<span class="fileinput-new">Event Image 3</span><span class="fileinput-exists">Change Image 1</span>',
                    ),
                ),
            ), */
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
                "value" => set_value('contact_name', (isset($arrResult->contact_name) ? $arrResult->contact_name : $this->input->post("contact_name"))),
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
            'last_name' => array("name" => "contact_lastname",
                "type" => "text",
                "id" => "contact_lastname",
                "class" => "form-control",
                "placeholder" => "Contact Person's Last Name",
                "validate" => '',
                "error" => 'Contact Person\'s Name',
                "value" => set_value('contact_name', (isset($arrResult->contact_lastname) ? $arrResult->contact_lastname : $this->input->post("contact_lastname"))),
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
            'phone' => array("name" => "contact_mobile",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control validate[required]",
                "placeholder" => "Mobile Number*",
                "validate" => 'regex_match[/^[\d\-\+\s]+$/]',
                "error" => 'Mobile Number',
                "value" => set_value('phone', (isset($arrResult->contact_mobile) ? $arrResult->contact_mobile : $this->input->post("contact_mobile"))),
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
            // bhavana
            'Telephone' => array("name" => "contact_phone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control",
                "placeholder" => "Telephone Number",
                "validate" => '',
                "error" => 'Telephone Number',
                "value" => set_value('phone', (isset($arrResult->contact_phone) ? $arrResult->contact_phone : $this->input->post("contact_phone"))),
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
                "placeholder" => "Contact Email ID*",
                "validate" => 'required',
                "error" => 'Contact Email',
                "value" => set_value('email', (isset($arrResult->contact_email) ? $arrResult->contact_email : $this->input->post("contact_email"))),
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
                "value" => set_value('status', (isset($arrResult->status) ? $arrResult->status : $this->input->post("status"))),
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
                ),
            ),
        );

        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/event/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/event/add';
        }
        $arrData['fileUpload'] = true;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
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
            if (isset($data['industry_id'])) {
                $arrTags = array();
                foreach ($data['industry_id'] as $industry) {
                    $arrTags[$i]['event_id'] = $event_id;
                    $arrTags[$i]['industry_id'] = $industry;
                    $i++;
                }
                $this->has_model->tableName = 'event_has_industry';
                if (!is_null($id)) {
                    $arrHasDelete = array("event_id" => $id);

                    if (!$this->has_model->delete($arrHasDelete))
                        $error = TRUE;
                }
                $this->has_model->save($arrTags);
            }
            if (isset($data['functionality_id'])) {
                $arrTags = array();
                foreach ($data['functionality_id'] as $industry) {
                    $arrTags[$i]['event_id'] = $event_id;
                    $arrTags[$i]['functionality_id'] = $industry;
                    $i++;
                }
                $this->has_model->tableName = 'event_has_functionality';
                if (!is_null($id)) {
                    $arrHasDelete = array("event_id" => $id);

                    if (!$this->has_model->delete($arrHasDelete))
                        $error = TRUE;
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
		if(isset($arrData['event_start']))
		{
		$date_start=date('Y-m-d h:i:s', strtotime($arrData['event_start']));
		}
		if(isset($arrData['event_end']))
		{
		$date_end=date('Y-m-d h:i:s', strtotime($arrData['event_end']));
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
            $this->db->select('(select group_concat(event_has_industry.industry_id) from event_has_industry where event_id = ' . $id . ') as industry_id   
        ,(select group_concat(event_has_functionality.functionality_id) from event_has_functionality where event_id = ' . $id . ') as functionality_id,   
        ', false);
        }

        $this->db->select('event.*,event.id as event_id,event_profile.*, organizer.name as organizer_name');

        if (!is_null($id)) {
            $this->db->select('(select group_concat(tag_name) as tag from tag
            INNER JOIN tag_relation ON tag_relation.tag_id = tag.id
            where object_id = ' . $id . ' AND object_type="event") as tag_name   
        
        ', false);
        }
        $this->db->join('organizer','event.organizer_id = organizer.id');
		if($search =='NULL')
		{
		$this->db->order_by('event.created_date', 'desc');
		}
		else
		{
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
        foreach ($form['fields'] as $element) {

            if ($element['type'] == 'file' && $_FILES[$element['name']]['name'] != '') {
                echo 
                $config = $element['upload_config'];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($element['name'])) {
                    $data = $this->upload->display_errors();
                    
                } else {
                    $data[$element['name']] = $this->upload->file_name;
                    
                }
            }
        }
        return true;
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
        $result = $this->db->get('event');

        return $result->result_array();
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
        //echo '<pre>'; print_r($arrData); exit;
        $this->db->select('status');
        $this->db->where_in('event_id',$arrData);
        $result = $this->db->get('exhibitor');
        $res = $result->result_array();

        //echo '<pre>'; print_r($res); exit;
        foreach ($res as $value) {
            if($value['status'] == 1 ) {
                return 'AEx';
            } 
        }
        
//        $this->db->select('status');
        $this->db->where_in('event_id',$arrData);
        $result = $this->db->get('event_has_attendee');
        $resAttendee = $result->result_array();

        foreach ($res as $value) {
            if($value['status'] == 1 ) {
                return 'AAt';
            } 
        }

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
