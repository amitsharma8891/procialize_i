<?php

class tag_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1","0");
    public $order_by = 'ASC';
    public $order_name = 'tag.id';
    public $fields = array(
        "id",
        "tag_name",
        "created_by",
        "created_date",
    );

    function generate_fields($id = NULL) {

        $arrResult = array();
        if (!is_null($id))
            $arrResult = $this->get($id, TRUE);

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'tag_name' => array("name" => "tag_name",
                "type" => "text",
                "id" => "tag_name",
                "class" => "form-control",
                "placeholder" => "Tag Name",
                "validate" => 'required',
                "error" => 'Tag Name',
                "value" => set_value('name', (isset($arrResult->tag_name) ? $arrResult->tag_name : $this->input->post('tag_name'))),
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
                        "content" => '<div>Tag Name</div>',
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
                        "content" => '<div>Status</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
        );
        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/tag/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/tag/add';
        }
        $arrData['fileUpload'] = false;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * save
     *
     * saves tag
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
            $result = $this->db->insert('tag', $arrData);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $result = $this->db->update('tag', $arrData);
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
     * gets tag
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
        $this->db->order_by($this->order_name, $this->order_by);
        $this->db->where_in('status', $this->status);
        if ($row) {
            $result = $this->db->get('tag')->row();

            return $result;
        } else {

            $result = $this->db->get('tag');
            //echo '<pre>'; print_r($result); exit;
            return $result->result_array();
        }
    }

    /**
     * getAll
     *
     * gets all tags
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @params  boolean $search to return searched value matching result
     * @params  boolean $fields to return searched field matching result
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array()) { 

        if (!is_null($id))
            $this->db->where('tag.id', $id);

        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                $where = "$field LIKE '%$search%'";
                $this->db->or_where($where);
            }
        }
        
        $result = $this->db->get('tag');
        return $result->result_array();
    }
    /**
     * search
     *
     * gets tag
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function search($search = NULL) {
        if (!is_null($search))
            $this->db->like('tag_name', $search);
        $this->db->where_in('status', $this->status);
        $result = $this->db->get('tag');
        //echo '<pre>'; print_r($result); exit;
        return $result->result_array();
    }

    /**
     * getTagByName
     *
     * gets tag
     * 
     * @author  Aatish
     * @access  public
     * @params  array $values
     * @params  boolean $row to return single row
     * @return  void
     */
    function getTagByName($values = array()) {
        $this->db->select('id', 'tag_name');
        if (!is_null($values))
            $this->db->where_in('tag_name', $values);
        $this->db->where_in('status', $this->status);
        $result = $this->db->get('tag');
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
        
        $this->db->where_in('id', $arrData);
        if ($this->db->delete('tag')) {
            return true;
        } else {
            return false;
        }
    }

}

?>
