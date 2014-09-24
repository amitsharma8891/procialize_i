<?php

class top_level_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'top_level.id';
    public $fields = array(
        "id",
        "name",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "app_owner_company",
        "first_name",
        "last_name",
        "primary_color",
        "secondary_color",
        "app_logo",
        "app_background_color",
        "image1",
        "image2",
        "image3",
        "user_id",
    );

    /**
     * generate_fields
     *
     * generates form field elements
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    function generate_fields($id = NULL) {
        $arrResult = array();
        if (!is_null($id))
            $arrResult = $this->get($id, TRUE);

        $arrData['fields'] = array();


        $arrData['fields'] = array(
            'name' => array(
                "name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control",
                "placeholder" => "App Name",
                "value" => set_value('name', (isset($arrResult->name) ? $arrResult->name : $this->input->post('name'))),
                "validate" => 'required',
                "error" => 'First Name',
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
            'app_owner_company' => array(
                "name" => "app_owner_company",
                "type" => "text",
                "id" => "app_owner_company",
                "class" => "form-control",
                "placeholder" => "App Owner Company",
                "value" => set_value('app_owner_company', (isset($arrResult->app_owner_company) ? $arrResult->app_owner_company : $this->input->post('app_owner_company'))),
                "validate" => 'required',
                "error" => 'App Owner Company',
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
            ),
            'first_name' => array(
                "name" => "first_name",
                "type" => "text",
                "id" => "first_name",
                "class" => "form-control",
                "placeholder" => "First Name",
                "value" => set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : $this->input->post('first_name'))),
                "validate" => 'required',
                "error" => 'First Name',
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
            'last_name' => array(
                "name" => "last_name",
                "type" => "text",
                "id" => "last_name",
                "class" => "form-control",
                "placeholder" => "Last Name",
                "value" => set_value('last_name', (isset($arrResult->last_name) ? $arrResult->last_name : $this->input->post('last_name'))),
                "validate" => 'required',
                "error" => 'Last Name',
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
            ),
            'primary_color' => array(
                "name" => "primary_color",
                "type" => "text",
                "id" => "primary_color",
                "class" => "form-control cp-basic",
                "placeholder" => "Primary Color",
                "value" => set_value('first_name', (isset($arrResult->primary_color) ? $arrResult->primary_color : $this->input->post('primary_color'))),
                "validate" => 'required',
                "error" => 'Primary Color',
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
            'secondary_color' => array(
                "name" => "secondary_color",
                "type" => "text",
                "id" => "secondary_color",
                "class" => "form-control cp-basic",
                "placeholder" => "Secondary Color",
                "value" => set_value('secondary_color', (isset($arrResult->secondary_color) ? $arrResult->secondary_color : $this->input->post('secondary_color'))),
                "validate" => 'required',
                "error" => 'Secondary Color',
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
            ),
            'status' => array(
                "name" => "status",
                "type" => "dropdown",
                "id" => "form-status",
                "class" => "form-control chosen-select",
                "attributes" => '  data-placeholder="Status" ',
                "placeholder" => "Status",
                "options" => array("0" => "Status - Disabled", "1" => "Status - Enabled"),
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
                ),
            ),
        );
        if (isset($arrData->status)) {
            if ($arrResult->status)
                $arrData['fields']['status']['checked'] = TRUE;
        }
        $arrData['action'] = '';
        $arrData['fileUpload'] = false;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * save
     *
     * saves top level
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	array $data 
     * @params	int $id 
     * @return	void
     */
    function save($data, $id = NULL) {
        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $result = $this->db->insert('top_level', $data);
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('top_level', $data);
        }
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * get
     *
     * gets top level
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	int $id
     * @params	boolean $row to return single row
     * @return	void
     */
    function get($id = NULL, $row = FALSE) {


        if ($row) {
            $this->db->where('id', $id);
            $result = $this->db->get('top_level')->row();
            return $result;
        } else {
            $result = $this->db->get('top_level');
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
            $this->db->where('top_level.id', $id);
        $this->db->join('user', 'top_level.user_id = user_id');
        $this->db->order_by($this->order_name, $this->order_by);

        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                $where = "$field LIKE '%$search%'";
                $this->db->or_where($where);
            }
        }
        $result = $this->db->get('top_level');
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
        $this->db->where_in('id', $arrData);
        if ($this->db->delete('top_level')) {
            return true;
        } else {
            return false;
        }
    }

}

?>
