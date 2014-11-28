<?php

class place_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $order_by = 'ASC';
    public $order_name = 'name';
    public $object;
    //public $order_name = 'email_template.created_date';
    public $fields = array(
        "id",
        "name",
        "country_id",
        "created_by",
        "created",
        "modified_by",
        "modified",
    );

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
    function saveAll($country_city_type = NULL, $data, $id = NULL) {
        if (isset($data['email_id']) && !empty($data['email_id'])) {
            $id = $data['email_id'];
        }

        $error = FALSE;
        try {
            $this->db->trans_begin();

            $this->save($country_city_type, $data, $id);
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
    function save($country_city_type, $data, $id = NULL) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
//        if (!isset($arrData['status']))
//            $arrData['status'] = 1;
        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created'] = date("Y-m-d H:i:s");
            $result = $this->db->insert($country_city_type, $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update($country_city_type, $arrData);
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
    function getAll($country_city_type = NULL, $id = NULL, $row = FALSE, $search = NULL, $fields = array(), $where = NULL, $type = 'LIKE') {
        //  echo $this->order_name; echo $this->order_by;  var_dump($search); die;
        $where = $country_city_type . '.id';
        if (!is_null($id))
            $this->db->where($where, $id);

        $this->db->select($country_city_type . '.*');
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

//        $this->db->where_in('email_template.status', $this->status);
        $this->db->order_by("name", "asc");
        $this->db->group_by($country_city_type . '.id');


        if ($row) {
            $result = $this->db->get($country_city_type)->row();

            return $result;
        } else {
            $result = $this->db->get($country_city_type);
            //echo $this->db->last_query();exit;
            return $result->result_array();
        }
    }

    /**
     * get
     *
     * gets email_template
     * 
     * @author  Anupam
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get($country_city_type = NULL, $id = NULL, $row = FALSE, $where = NULL) {
        $where = $country_city_type . '.id';
        if (!is_null($id))
            $this->db->where($where, $id);
        if ($id) {
            $result = $this->db->get($country_city_type)->row();
            return $result;
        } else {
            $result = $this->db->get($country_city_type);
            return $result->result_array();
        }
    }

    /**
     * get
     *
     * gets email_template
     * 
     * @author  Anupam
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get_place($country_city_type = NULL, $id = NULL, $row = FALSE, $where = NULL) {
        $where = $country_city_type . '.name';
        if (!empty($id))
            $this->db->where($where, $id);
        if (!empty($id)) {
            $result = $this->db->get($country_city_type)->row();
            return $result;
        } else {
            $result = $this->db->get($country_city_type);
            return $result->result_array();
        }
    }

    function getDropdownValues($type, $search = NULL, $field = NULL) {
        $dropDownValues = array();
        if ($type == 'city') {
            if (!empty($search)) {
                $country = $this->get_place('country', $search, '1', array('country.name'));
                $search = $country->id;
                $field = array('city.country_id');
                $dropDownValues = $this->getAll($type, NULL, NULL, $search, $field);
            }
        } else {
            $dropDownValues = $this->getAll($type);
        }
//        $dropDownValues = $this->getAll($type);
        $arrDropdown = array();
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['name']] = $value['name'];
        }
        return $arrDropdown;
    }

}
