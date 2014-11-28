<?php

class image_map_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'image_map.event_id';
    public $object;
    //public $order_name = 'email_template.created_date';
    public $fields = array(
        "id",
        "name",
        "parent_id",
        "image_name",
        "event_id",
        "coordinates",
        "child_coords",
        "created",
        "modified"
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
                "placeholder" => "Please Enter Email Template Name",
                "validate" => 'required|trim|is_unique[email_template.username]',
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
                        "content" => '<div>Email Template Name <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'subject' => array("name" => "subject",
                "type" => "text",
                "id" => "subject",
                "class" => "form-control validate[required]",
                "placeholder" => "Please Enter Email Template Subject",
                "validate" => 'required',
                "error" => 'Subject',
                "value" => set_value('subject', (isset($arrResult->subject) ? $arrResult->subject : (isset($postarray['subject']) ? $postarray['subject'] : ''))),
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
                        "content" => '<div>Subject <span class="field_required">*</span></div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'body' => array("name" => "body",
                "type" => "textarea",
                "id" => "body",
                "class" => "form-control ckeditor",
                "placeholder" => "Please Enter Email Template Body",
                "validate" => '',
                "error" => 'Body',
                "style" => "dispaly:block !important",
                "value" => set_value('body', (isset($arrResult->body) ? $arrResult->body : (isset($postarray['body']) ? $postarray['body'] : ''))),
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
                        "content" => '<div>Body</div>',
                        "position" => "prependElement",
                    ),
                    array(
                        'tag' => 'div',
                        "close" => "close",
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
            $arrData['action'] = base_url() . 'manage/image_map/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/image_map/add';
        }
        setcookie("postarray", "", time() - 3600);
        $arrData['fileUpload'] = true;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves entire information of email_template
     * 
     * @author  Aatish Gore 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAll($data, $id = NULL) {
        if (isset($data['email_id']) && !empty($data['email_id'])) {
            $id = $data['email_id'];
        }

        $error = FALSE;
        try {
            $this->db->trans_begin();

            $last_insert_id = $this->save($data, $id);
            return $last_insert_id;
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
     * saves email_template
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
        if (is_null($id)) {
            $arrData['created'] = date("Y-m-d H:i:s");
            $result = $this->db->insert('image_map', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('image_map', $arrData);
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
     * gets all info email_template
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $where = 'image_map.id', $type = 'LIKE') {
        //  echo $this->order_name; echo $this->order_by;  var_dump($search); die;
        if (!is_null($id))
            $this->db->where($where, $id);
        $this->db->select('image_map.*');
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

//        $this->db->where_in('image_map.status', $this->status);
        $this->db->order_by("name", "asc");
        $this->db->group_by('image_map.id');


        if ($row) {
            $result = $this->db->get('image_map')->row();

            return $result;
        } else {
            $result = $this->db->get('image_map');
            //echo $this->db->last_query();exit;
            return $result->result_array();
        }
    }

    /**
     * get
     *
     * gets email_template
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
        if ($id) {
            $result = $this->db->get('image_map')->row();
            return $result;
        } else {
            $result = $this->db->get('image_map');
            return $result->result_array();
        }
    }

}
