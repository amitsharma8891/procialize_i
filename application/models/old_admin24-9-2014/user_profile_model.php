<?php

class user_profile_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $fields = array(
        "id",
        "company_name",
        "designation",
        "user_id",
        "phone",
        "mobile"
    );

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
        //echo '<pre>'; print_r($data); exit;
        $arrData = array();
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }

        //var_dump($id);
        //echo '<pre>';print_r($arrData);exit;

        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $result = $this->db->insert('user_profile', $arrData);
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('user_id', $id);
            $result = $this->db->update('user_profile', $arrData);
        }
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>