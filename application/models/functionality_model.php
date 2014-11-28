<?php

class functionality_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }
    public $status = array("1","0");
    public $order_by = 'ASC';
    public $order_name = 'functionality.id';
    
    function generate_fields($id = NULL) {

        $arrResult = array();
        if (!is_null($id))
            $arrResult = $this->get($id, TRUE);

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control",
                "placeholder" => "Functionality Name",
                "validate" => 'required',
                "error" => 'Functionality Name',
                "value" => set_value('name', (isset($arrResult->name) ? $arrResult->name : $this->input->post('name'))),
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
                        "content" => '<div>Functionality Name</div>',
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
        );
        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/functionality/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/functionality/add';
        }
        $arrData['fileUpload'] = false;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * save
     *
     * saves functionality
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function save($data, $id = NULL) {
        //echo '<pre>'; print_r($data); exit;
        if (!isset($data['status']))
            $data['status'] = 1;
        if (is_null($id)) {
            $data['created_by'] = getCreatedUserId();
            $data['created_date'] = date("Y-m-d H:i:s");
            $result = $this->db->insert('functionality', $data);
            $id = $this->db->insert_id();
        } else {
            $data['modified_by'] = getCreatedUserId();
            $data['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('functionality', $data);
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
     * gets functionality
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
        if ($row) {
            $result = $this->db->get('functionality')->row();

            return $result;
        } else {
            $result = $this->db->get('functionality');
//         echo $this->db->last_query();
            //echo '<pre>'; print_r($result); exit;
            return $result->result_array();
        }
    }

    /**
     * getAll
     *
     * gets all functionality
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
            $this->db->where('functionality.id', $id);

        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                $where = "$field LIKE '%$search%'";
                $this->db->or_where($where);
            }
        }
        $result = $this->db->get('functionality');
        return $result->result_array();
    }

    /**
     * getDropdownValues
     *
     * gets industry dropdown values
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
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['id']] = $value['name'];
        }
        return $arrDropdown;
    }

    function checkSave($arrData = array()) {
        if (empty($arrData))
            return $arrData;
        $arrReturn = array();
        foreach ($arrData as $data) {
            $id = $this->check($data);
            if ($id) {
                array_push($arrReturn, $id);
            } else {
                $arrSave = array();
                $arrSave['name'] = $data;
                $id = $this->save($arrSave);
                array_push($arrReturn, $id);
            }
        }
        return $arrReturn;
    }

    /**
     * check_user
     *
     * checks if name exist
     * 
     * @author  Aatish 
     * @access  public
     * @params  array $data 
     * @params  $email
     * @return  void
     */
    function check($search, $field = 'name') {
        $this->db->select('id');
        $this->db->where($field, $search);
        $this->db->where($field . ' IS NOT NULL', null, false);
        $result = $this->db->get('functionality')->row();

        if ($result) {
            return $result->id;
        } else {
            return FALSE;
        }
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
        if ($this->db->delete('functionality')) {
            return true;
        } else {
            return false;
        }
    }

    function check_unique($data, $id= NULL) {
        //echo $id.'<pre>'; print_r($data); exit;
        $this->db->select('count(*) as count');
        $this->db->where('name', $data);
        if($id) {
            $this->db->where('id', $id);
        }
        $result_set = $this->db->get('functionality');
        $result = $result_set->result_array();
        //echo $this->db->last_query();
        //echo '<pre>'; print_r($result); exit;
        if($id) {
         if($result[0]['count'] == 1) {
            return TRUE;
         }   
        } else {
            if($result[0]['count'] == 0) {
                return TRUE;
            } else {
                return FALSE;
            }    
        }
    }


}

?>
