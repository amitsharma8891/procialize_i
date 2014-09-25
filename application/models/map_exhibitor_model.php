<?php

class map_exhibitor_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1", "0");
    public $order_by = 'ASC';
    public $order_name = 'map_exhibitor.id';
    public $object;
    //public $order_name = 'email_template.created_date';
    public $fields = array(
        "id",
        "name",
        "map_id",
        "exhibitor_id",
        "coordinates",
        "description",
        "event_id",
        "created",
        "modified"
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
    function saveAll($data, $id = NULL) {
        if (isset($data['email_id']) && !empty($data['email_id'])) {
            $id = $data['email_id'];
        }

        $error = FALSE;
        try {
            $this->db->trans_begin();

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
            echo "save";
            $result = $this->db->insert('map_exhibitor', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            echo "update";

            $result = $this->db->update('map_exhibitor', $arrData);
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
        $this->db->select('map_exhibitor.*');
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

        $this->db->order_by("name", "asc");
        $this->db->group_by('map_exhibitor.id');
        if ($row) {
            $result = $this->db->get('map_exhibitor')->row();
            return $result;
        } else {
            $result = $this->db->get('map_exhibitor');
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
            $result = $this->db->get('map_exhibitor')->row();
            return $result;
        } else {
            $result = $this->db->get('map_exhibitor');
            return $result->result_array();
        }
    }

}
