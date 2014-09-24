<?php

class tag_relation_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    function get($objType = NULL, $objId = NULL) {
        if (!is_nan($objType))
            $this->db->where('object_type', $objType);

        if (!is_nan($objId))
            $this->db->where('object_type', $objId);

        $result = $this->db->get('tag_relation');
        return $result->result_array();
    }


    function save_batch($data) {
        if(empty($data))
            return;
        $this->db->insert_batch('tag_relation',$data);
    }
    
    function delete($objType = NULL,$objId = NULL){
        if(is_null($objId) || is_null($objType))
            return false;
        $this->db->where('object_id',$objId);
        $this->db->where('object_type',$objType);
        $this->db->delete('tag_relation');
        
        return true;
    }
    

}