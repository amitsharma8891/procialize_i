<?php

class sponsor_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    public $object;
    public $event_id;
    public $status = array("1");
    public $order_by = 'ASC';
    public $order_name = 'sponser.id';
    public $fields = array(
        "id",
        "name",
        "description",
        "normal_ad",
        "splash_ad",
        "link",
        "display_order",
        "ad_starts",
        "ad_ends",
        "ad_starts_time",
        "ad_ends_time",
        "status",
        "contact_person_name",
        "contact_person_lname",
        "contact_person_email",
        "office_address",
        "contact_phone_number",
        "contact_mobile_number",
        "created_by",
        "created_date",
        "event_id",
        "user_id",
        "pvt_org_id",
    );

    function generate_fields($id = NULL) {
        $superadmin = $this->session->userdata('is_superadmin');


        $arrResult = array();
        if (!is_null($id)) {
            $arrResult = $this->getAll($id, TRUE);
            $this->object = $arrResult;
        }
        if (isset($arrResult->normal_ad)) {
            if ($arrResult->normal_ad != '') {
                $normal_ad = '<img src="' . base_url() . UPLOAD_SPONSOR_NORMAL_DISPLAY . $arrResult->normal_ad . '" alt="normal_ad">';
            } else {
                $normal_ad = '<img src="http://placehold.it/106x64" alt="">';
            }
        } else {
            $normal_ad = '<img src="http://placehold.it/106x64" alt="">';
        }
        if (isset($arrResult->splash_ad)) {

            if ($arrResult->splash_ad != '') {
                $splash_ad = '<img src="' . base_url() . UPLOAD_SPONSOR_SPLASH_DISPLAY . $arrResult->splash_ad . '" alt="splash_ad">';
            } else {
                $splash_ad = '<img src="http://placehold.it/106x64" alt="brochure">';
            }
        } else {
            $splash_ad = '<img src="http://placehold.it/106x64" alt="brochure">';
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

        //  echo '<pre>';print_r($arrResult);exit;
        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'event_id' => array(
                "type" => "hidden",
                "event_id" => isset($this->event_id) ? $this->event_id : '',
            ),
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control validate[required]",
                "placeholder" => "Company Name*",
                "validate" => 'required',
                "error" => 'Company Name',
                "value" => set_value('name', (isset($arrResult->name) && ($arrResult->name != '') ? $arrResult->name : (isset($postarray['name']) ? $postarray['name'] : ''))),
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
                        "content" => '<div>Company Name<span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'link' => array("name" => "link",
                "type" => "text",
                "id" => "website_link",
                "class" => "form-control",
                "placeholder" => "Sponsor's Website Link (to be opened when user clicks on it from the Mobile App)",
                "validate" => '',
                "error" => 'Link',
                "value" => set_value('link', (isset($arrResult->link) && ($arrResult->link != '') ? $arrResult->link : (isset($postarray['link']) ? $postarray['link'] : ''))),
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
                        "class" => "control-label form-label-placeholder ml0",
                        "content" => '<div>Sponsors Website Link (system will prefix what you type with http://)</div>',
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
            'normal_ad' => array("name" => "normal_ad",
                "type" => "file",
                "id" => "normal_ad",
                "class" => "form-control",
                "validate" => '',
                "placeholder" => "Normal Ad",
                "upload_config" => array(
                    "upload_path" => UPLOAD_SPONSOR_NORMAL,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '2048',
                    "height" => '49',
                    "width" => '401',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $normal_ad . '</div>',
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
                        "tag_data" => '<span class="fileinput-new"> Sponsor Ad<br>(401px x 49px)</span><span class="fileinput-exists">Change Image 1</span>',
                    ),
                ),
            ),
            'splash_ad' => array("name" => "splash_ad",
                "type" => "file",
                "id" => "splash_ad",
                "class" => "form-control",
                "placeholder" => "Splash Ad",
                "validate" => '',
                "upload_config" => array(
                    "upload_path" => UPLOAD_SPONSOR_SPLASH,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '2048',
                    "height" => '275',
                    "width" => '250',
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
                        'tag_data' => '<a href="#" title="remove" class="closebtn fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 100%; max-height: 80px;">' . $splash_ad . '</div>',
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
                        "tag_data" => '<span class="fileinput-new">Splash Ad<br>(250px x 275px)</span><span class="fileinput-exists">Change Image 2</span>',
                    ),
                ),
            ),
            'event_id' => array(
                "type" => "hidden",
                "event_id" => (isset($arrResult->event_id) ? $arrResult->event_id : $this->event_id),
            ),
            'contact_person_name' => array("name" => "contact_person_name",
                "type" => "text",
                "id" => "contact_person_name",
                "class" => "form-control ",
                "placeholder" => "Contact Person's First Name",
                "validate" => '',
                "error" => 'Contact Person\'s First Name',
                "value" => set_value('first_name', (isset($arrResult->contact_person_name) && ($arrResult->contact_person_name != '') ? $arrResult->contact_person_name : (isset($postarray['contact_person_name']) ? $postarray['contact_person_name'] : ''))),
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
                        "content" => '<div>Contact Persons First Name</div>',
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
            'contact_person_lname' => array("name" => "contact_person_lname",
                "type" => "text",
                "id" => "contact_person_lname",
                "class" => "form-control ",
                "placeholder" => "Contact Person's Last Name",
                "validate" => '',
                "error" => 'Contact Person\'s Last Name',
                "value" => set_value('contact_person_lname', (isset($arrResult->contact_person_lname) && ($arrResult->contact_person_lname != '') ? $arrResult->contact_person_lname : (isset($postarray['contact_person_lname']) ? $postarray['contact_person_lname'] : ''))),
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
                        "content" => '<div>Contact Persons Last Name</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            /*  */
            /*  'office_address' => array("name" => "office_address",
              "type" => "text",
              "id" => "office_address",
              "class" => "form-control",
              "placeholder" => "Office Address",
              "validate" => 'required',
              "error" => 'Office Address',
              "value" => set_value('email', (isset($arrResult->office_address) ? $arrResult->office_address : '')),
              "decorators" => array(
              array(
              "tag" => "div",
              "close" => "close",
              "class" => "form-group",
              ),
              array(
              "tag" => "div",
              "close" => "true",
              "class" => "col-sm-6"
              ),
              ),
              ), */
            'contact_mobile_number' => array("name" => "contact_mobile_number",
                "type" => "text",
                "id" => "mobile",
                "class" => "form-control",
                "placeholder" => "Mobile Number",
                "validate" => '',
                "error" => 'Mobile Number',
                "value" => set_value('contact_mobile_number', (isset($arrResult->contact_mobile_number) && ($arrResult->contact_mobile_number != '') ? $arrResult->contact_mobile_number : (isset($postarray['contact_mobile_number']) ? $postarray['contact_mobile_number'] : ''))),
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
                        "content" => '<div>Mobile Number</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'contact_phone_number' => array("name" => "contact_phone_number",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control",
                "placeholder" => "Telephone Number",
                "validate" => '',
                "error" => 'Phone Number',
                "value" => set_value('contact_phone_number', (isset($arrResult->contact_phone_number) && ($arrResult->contact_phone_number != '') ? $arrResult->contact_phone_number : (isset($postarray['contact_phone_number']) ? $postarray['contact_phone_number'] : ''))),
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
                        "content" => '<div>Telephone Number</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'contact_person_email' => array("name" => "contact_person_email",
                "type" => "text",
                "id" => "email",
                "class" => "form-control",
                "placeholder" => "Contact Email",
                "validate" => '',
                "error" => 'Contact Email',
                "value" => set_value('contact_person_email', (isset($arrResult->contact_person_email) && ($arrResult->contact_person_email != '') ? $arrResult->contact_person_email : (isset($postarray['contact_person_email']) ? $postarray['contact_person_email'] : ''))),
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
                        "content" => '<div>Contact Email</div>',
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
                "error" => 'Event',
                "value" => set_value((isset($arrResult->event_id) ? $arrResult->event_id : $this->input->post('event_id'))),
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
            $arrData['action'] = base_url() . 'manage/sponsor/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/sponsor/add';
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
                $user = array();
                $user['username'] = $data['username'];
                $user['password'] = $data['password'];
                $user['type_of_user'] = 'S';
                $user['top_level_id'] = getTopLevelId();
                $user['created_by'] = getCreatedUserId();
                $user['created_date'] = date("Y-m-d H:i:s");
                $user_id = $this->user_model->save($user);
                $data['user_id'] = $user_id;
            }
            #save contact person as attendee
            unset($data['username']);
            unset($data['password']);
            if (is_null($id)) {
                //$data['event_id'] = 20;
                $sponsor_id = $this->save($data, $id);
            } else {
                //echo '<pre>'; print_r($data); exit;
                $sponsor_id = $this->save($data, $id);
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

            $result = $this->db->insert('sponser', $arrData);
            $id = $this->db->insert_id();
        } else {

            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('sponser', $arrData);
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
     * check_splash
     *
     * checks if splash add exist
     * 
     * @author  aatish
     * @access  public
     * @params  int $id
     * @params  null
     * @return  void
     */
    function check_splash($event_id = NULL, $id = NULL) {

        $this->db->select('id');
        $this->db->where('event_id', (is_null($event_id)) ? $this->event_id : $event_id);
        $this->db->where('splash_ad != ""');
        if (!is_null($id)) {
            $this->db->where('id !=', $id);
        }
        $result = $this->db->get('sponser');
        if ($result->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function update_splash($event_id = NULL, $id = NULL) {
        if ($_FILES['splash_ad'] != '') {

            $this->db->where('event_id', (is_null($event_id)) ? $this->event_id : $event_id);
            $this->db->update('sponser', array('splash_ad' => ''));
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
            $result = $this->db->get('sponser')->row();

            return $result;
        } else {
            $result = $this->db->get('sponser');
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
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $type = 'LIKE',$where = 'sponser.id') {

        if (!is_null($id)) {

            $this->db->select('event.name as event_name,sponser.name as sponser_name,sponser.*');
            $this->db->join('user', 'sponser.user_id = user.id');
            // $this->db->join('event', 'sponser.event_id = event.id');

            $this->db->join('event', 'sponser.event_id = event.id');

            $this->db->where($where, $id);
            $result = $this->db->get('sponser')->row();
            return $result;
        } else {
            $this->db->select('event.name as event_name,sponser.name as sponser_name,sponser.*');

            $this->db->join('event', 'sponser.event_id = event.id');
            //$this->db->where('sponser.id', $id);
            if ($search == 'NULL') {
                $this->db->order_by('sponser.created_date', 'desc');
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

            $superadmin = $this->session->userdata('is_superadmin');
            if (!$superadmin)
                $this->db->where('sponser.event_id', $this->event_id);

            $this->db->join('user', 'sponser.user_id = user.id');
            $result = $this->db->get('sponser');
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

            if ($element['name'] == 'normal_ad') {

                $img_location = UPLOAD_SPONSOR_NORMAL_DISPLAY;
            } else if ($element['name'] == 'splash_ad') {
                $img_location = UPLOAD_SPONSOR_SPLASH_DISPLAY;
            }
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
                    $imgfile = $img_location . $this->upload->file_name;
                    $imginfo = getimagesize($imgfile);
                    $width = $imginfo[0];
                    $height = $imginfo[1];
                    $newwidth = $config['width'];
                    $newheight = $config['height'];


                    if($imginfo['mime'] =='image/jpeg') {
                        $tmpb=imagecreatetruecolor($newwidth,$newheight);
                        //echo '<pre>'; print_r($tmpb); exit;
                        $tes = imagecopyresampled($tmpb,imagecreatefromjpeg($imgfile),0,0,0,0,$newwidth,
                        $newheight,$width,$height);
                        //echo '<pre>'; print_r($tes); exit;
                        unlink($imgfile);
                        imagejpeg($tmpb, $imgfile , 90); 
                    } elseif($imginfo['mime'] =='image/png') {
                        
                        $image = imagecreatefrompng ( $imgfile );
                        $new_image = imagecreatetruecolor($newwidth,$newheight); // new wigth and height
                        imagealphablending($new_image , false);
                        imagesavealpha($new_image , true);
                        imagecopyresampled ( $new_image, $image, 0, 0, 0, 0, $newwidth, $newheight, imagesx ( $image ), imagesy ( $image ) );
                        $image = $new_image;

                        // saving
                        imagealphablending($image , false);
                        imagesavealpha($image , true);
                        imagepng ( $image, $imgfile );
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
        if ($this->db->delete('sponser')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * getDropdownValues
     *
     * gets organizer
     *  dropdown values
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getDropdownValues($id = NULL) {
        $dropDownValues = $this->get();
        $arrDropdown = array();
        $arrDropdown[''] = 'Select Sponsor';
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['id']] = $value['name'];
        }
        return $arrDropdown;
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
    function check_unique($company, $event, $id = null) {

        $this->db->where('event_id', $event);
        $this->db->where('name', $company);
        $result = $this->db->get('sponser');
        $res = $result->result_array();
        //echo '<pre>'; print_r($id); exit;
        if (!is_null($id)) {
            if ($id == $res[0]['id']) {
                return FALSE;
            }
        } else {
            if (!empty($res)) {
                return TRUE;
            }
        }
    }

	/**
     * get_sponsor_analytics
     *
     * Get Sponsor anaytics
     * 
     * @author  Aatish 
     * @access  public
     * @params  NULL
     * @return  void
     */
	function get_sponsor_analytics($where){
		$this->db->select('count(sponser.id) cnt,sponser.name as name,normal_ad,splash_ad');
		$this->db->where($where);
		$this->db->join('sponser','sponser.id = analytics.subject_id');
		$this->db->group_by('name');
		$result = $this->db->get('analytics');
		$res = $result->result_array();
		return $res;
	}



}

?>