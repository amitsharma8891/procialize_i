<?php

class organizer_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'organizer.name';
    public $object;
    //public $order_name = 'organizer.created_date';
    public $fields = array(
        "id",
        "name",
        "description",
        "organiser_photo",
        "status",
        "mail_sent",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "user_id",
        "pvt_org_id"
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
            $this->object = $arrResult;
            if ($arrResult->organiser_photo == '') {
                unset($arrResult->organiser_photo);
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

        if (isset($arrResult->organiser_photo)) {
            if ($arrResult->organiser_photo != '') {
                //	echo "hfgdhdfdfg";
                $up_photo = '<img src="' . base_url() . UPLOAD_ORGANIZER_LOGO_DISPLAY . $arrResult->organiser_photo . '" alt="photo">';
            } else {
                //	echo "4234234234";
                $up_photo = '<img src="http://placehold.it/106x64" alt="photo">';
            }
        } else {
            $up_photo = '<img src="http://placehold.it/106x64" alt="photo">';
        }
        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control validate[required]",
                "placeholder" => "Please Enter Organizer Name",
                "validate" => 'required|trim|is_unique[user.username]',
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
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Organizer Name <span class="field_required">*</span></div>',
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
            'organiser_photo' => array(
                "name" => "organiser_photo",
                "type" => "file",
                "id" => "normal_ad",
                "class" => "form-control ",
                "placeholder" => "Organizer Logo *",
                //"validate" => 'required',
                "upload_config" => array(
                    "upload_path" => UPLOAD_ORGANIZER_LOGO_DISPLAY,
                    "allowed_types" => 'jpg|png|jpeg',
                    "max_size" => '3072',
                    "height" => '180',
                    "width" => '180',
                ),
                "error" => 'Organizer Logo',
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
                        "tag_data" => '<span class="fileinput-new"><i class="fa fa-picture-o"></i> Organizer Logo *</span><span class="fileinput-exists">Change Logo</span>',
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-1",
                        "content" => "", /* . (isset($arrResult->photo) ? '<img src="' . base_url() . UPLOAD_ATTENDEE_PHOTO_DISPLAY . $arrResult->photo . '" width="50" />' : ''), */
                        "position" => "appendOuter",
                    ),
                    array("tag" => "div",
                        "close" => "close",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                        "content" => '<h3 class="col-sm-12">Login Details</h3>',
                        "position" => "appendOuter",
                    ),
                ),
            ),
            'first_name' => array("name" => "first_name",
                "type" => "text",
                "id" => "first_name",
                "class" => "form-control validate[required]",
                "placeholder" => "Please Enter Organizer's First Name",
                "validate" => 'required',
                "error" => 'First Name',
                "value" => set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : (isset($postarray['first_name']) ? $postarray['first_name'] : ''))),
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
                        "content" => '<div>First Name <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'last_name' => array("name" => "last_name",
                "type" => "text",
                "id" => "last_name",
                "class" => "form-control ",
                "placeholder" => "Please Enter Organizer's Last Name",
                "validate" => '',
                "error" => 'Last Name',
                "value" => set_value('last_name', (isset($arrResult->last_name) ? $arrResult->last_name : (isset($postarray['last_name']) ? $postarray['last_name'] : ''))),
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
                        "content" => '<div>Last Name</div>',
                        "position" => "prependElement",
                    ),
                    array(
                        'tag' => 'div',
                        "close" => "close",
                    ),
                ),
            ),
            'username' => array("name" => "username",
                "type" => "text",
                "id" => "username",
                "class" => "form-control validate[required]",
                "placeholder" => "Choose a username that contains only letters & numbers",
                "validate" => 'required',
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
                        "content" => '<div>Username <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'email' => array("name" => "email",
                "type" => "text",
                "id" => "email",
                "class" => "form-control validate[required,custom[email]]",
                "placeholder" => "What's your email address? ",
                "validate" => 'required|is_unique[user.email]',
                "error" => 'Email',
                "value" => set_value('email', (isset($arrResult->email) ? $arrResult->email : (isset($postarray['email']) ? $postarray['email'] : ''))),
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
                        "content" => '<div>Email-ID <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close"
                    ),
                ),
            ),
            'password' => array("name" => "password",
                "type" => "password",
                "id" => "password",
                "class" => "form-control validate[required]",
                "placeholder" => "Enter Password.",
                "validate" => 'required',
                "error" => 'Password',
                "value" => set_value('password'),
                //"value" => set_value('password', (isset($arrResult->email) ? $arrResult->email : (isset($postarray['password']) ? $postarray['password'] : ''))),
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
                        "content" => '<div>Password <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'cpassword' => array("name" => "cpassword",
                "type" => "password",
                "id" => "cpassword",
                "class" => "form-control validate[required,equals[password]]",
                "placeholder" => "Confirm Password",
                "validate" => 'required|matches[password]',
                "error" => 'Confirm Password',
                "value" => set_value('password'),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close"
                    ),
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Confirm Password <span class="field_required">*</span></div>',
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
                "value" => set_value('status', (isset($arrResult->status) ? $arrResult->status : (isset($postarray['status']) ? $postarray['status'] : ''))),
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
                    array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div class"form-label-placeholder">Status</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
        );

        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/organizer/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/organizer/add';
        }
        setcookie("postarray", "", time() - 3600);
        $arrData['fileUpload'] = true;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves entire information of organizer
     * 
     * @author  Aatish Gore 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAll($data, $id = NULL) {
        //echo '<pre>'; print_r($data); exit;
        $error = FALSE;
        try {
            $this->db->trans_begin();

            if (!is_null($id)) {
                $org = $this->getAll($id);
                //echo '123<pre>'; print_r($org); exit;
                if ($org[0]['user_id']) {
                    $user_id = $this->user_model->saveOrg($data, $org[0]['user_id']);
                }
            } else {
                $user_id = $this->user_model->save($data);
                $data['user_id'] = $user_id;
            }

            $this->save($data, $id);
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
     * saves organizer
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
// print_r($arrData);
        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");

            $result = $this->db->insert('organizer', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('organizer', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

    function save_org($id = NULL, $data) {
        $user_data = $data;
        unset($user_data['name']);
        unset($user_data['cpassword']);
        unset($user_data['user_id']);
        unset($user_data['btnSave']);
        unset($user_data['app_logo_image']);
        unset($user_data['is_pvt_id']);

        $arrData = $data;
        unset($arrData['first_name']);
        unset($arrData['last_name']);
        unset($arrData['password']);
        unset($arrData['cpassword']);
        unset($arrData['email']);
        unset($arrData['username']);
        unset($arrData['top_level_id']);
        unset($arrData['type_of_user']);
        unset($arrData['btnSave']);
        unset($arrData['pvt_org_id']);


        if (!$id) {
            if (isset($user_data['password']) && !empty($user_data['password'])) {
                $user_data['password'] = md5($user_data['password']);
            }
            $result = $this->db->insert('user', $user_data);
            $id = $this->db->insert_id();
            $arrData['user_id'] = $id;
            $arrData['pvt_org_id'] = 1;
            $arrData['organiser_photo'] = $arrData['app_logo_image'];
            unset($arrData['app_logo_image']);
            $result = $this->db->insert('organizer', $arrData);
        } else {
            if (isset($user_data['password']) && empty($user_data['password'])) {
                unset($user_data['password']);
            } else {
                $user_data['password'] = md5($user_data['password']);
            }
            $this->db->where('id', $id);
            $result = $this->db->update('user', $user_data);
            if (isset($arrData['app_logo_image']) && empty($arrData['app_logo_image'])) {
                unset($arrData['app_logo_image']);
            } else {
                $arrData['organiser_photo'] = $arrData['app_logo_image'];
                unset($arrData['app_logo_image']);
            }
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['user_id'] = $id;
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('user_id', $id);
            $result = $this->db->update('organizer', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

    /**
     * getAll
     *
     * gets all info organizer
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $where = 'organizer.id', $type = 'LIKE') {
        //  echo $this->order_name; echo $this->order_by;  var_dump($search); die;
        if (!is_null($id))
            $this->db->where($where, $id);

        $this->db->select('organizer.id as organizer_id,organizer.*,user.*,event.id as event_id');
        $this->db->order_by($this->order_name, $this->order_by);
        $this->db->join('event', 'event.organizer_id = organizer.id', 'left');
        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                if ($type == 'LIKE') {
                    $where = "$field LIKE '%$search%'";
                    $this->db->or_where($where);
                    //
                } else if ($type == 'AND') {

                    $this->db->where($field, $search);
                } else if ($type = 'or') {
                    $this->db->or_where($field, $search);
                }
            }
        }

        $this->db->where_in('organizer.status', $this->status);
        $this->db->join('user', 'user.id = organizer.user_id');
        $this->db->group_by('organizer.id');


        if ($row) {
            $result = $this->db->get('organizer')->row();

            return $result;
        } else {
            $result = $this->db->get('organizer');
            //echo $this->db->last_query();exit;
            return $result->result_array();
        }
    }

    /**
     * get
     *
     * gets organizer
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
        if ($row) {
            $result = $this->db->get('organizer')->row();
            return $result;
        } else {
            $result = $this->db->get('organizer');
            return $result->result_array();
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
        $arrDropdown[''] = 'Select Organizer';
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['id']] = $value['name'];
        }
        return $arrDropdown;
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
        if ($this->db->delete('organizer')) {
            return true;
        } else {
            return false;
        }
    }

    function sendMail($data = array()) {
        if (empty($data))
            return false;
        $status = true;
        foreach ($data as $id) {
            $objOrg = $this->getAll($id, true);
            // echo '<pre>';
            // print_r($objOrg);
            // exit;
            if ($objOrg->email != '' && $objOrg->mail_sent == 0) {
                $to = $objOrg->email;


                //MAIL TEMLATE***
                $email_template = get_email_template('event_credentials_organizer');
                $keywords = array('{app_name}', '{username}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}');
                $replace_with = array(
                    $email_template['setting']['app_name'],
                    $objOrg->username,
                    $email_template['setting']['app_contact_email'],
                    SITE_URL,
                    CLIENT_IMAGES,
                    '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">'
                );
                $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                $html = str_replace($keywords, $replace_with, $email_template['body']);
                //MAIL TEMLATE CLOSE***

//
//                $subject = 'Welcome to Procialize';
//                $message = "Welcome to Procialize - the platform where you can Professionally Socialize ! 
//
//Please use below credentials and Manage your own Event, in your own style :) 
//
//Username: {$objOrg->username}
//
//Feel free to reachout to us for any queries ! 
//
//Team Procialize";
                if (sendMail($to, $subject, $html)) {
                    $arrData['mail_sent'] = 1;
                    $this->save($arrData, $id);
                }
            } else {
                $status = false;
            }
        }
        return $status;
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
        //echo '<pre>'; print_r($_FILES); exit;
        foreach ($form['fields'] as $element) {

            if ($element['type'] == 'file' && $_FILES[$element['name']]['name'] != '') {
                $config = $element['upload_config'];
                //echo '<pre>'; print_r($config); exit;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($element['name'])) {
                    $data[] = $this->upload->display_errors();
                    $return = false;
                } else {

                    //echo 'img name = '.$this->upload->file_name; exit;
                    $data[$element['name']] = $this->upload->file_name;
                    //image resize code
                    $img_name = $this->upload->file_name;
                    $imgfile = UPLOAD_ORGANIZER_LOGO_DISPLAY . $this->upload->file_name;
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
    function checkcurrentPass($current_password, $user_id) {

        if (!empty($current_password)) {
            $this->db->where('password', $current_password);
            $this->db->where('id', $user_id);
            $result = $this->db->get('user');
        }
        if ($result->num_rows) {
            return True;
        } else {
            return False;
        }
    }

}
