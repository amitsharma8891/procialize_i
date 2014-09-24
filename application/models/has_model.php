<?php

class has_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $tableName = '';

    public function save($data) {
        if (empty($data))
            return;
        if ($this->tableName == '')
            return;
        $this->db->insert_batch($this->tableName, $data);
    }

    public function saveSingle($data) {
        if (empty($data))
            return;
        if ($this->tableName == '')
            return;
        $this->db->insert($this->tableName, $data);
    }

    public function delete($data) {

        if ($this->tableName == '')
            return false;
        $this->db->delete($this->tableName, $data);
        return true;
    }

}
