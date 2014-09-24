<?php

class survey_question_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1");
    public $fields = array(
        "id",
        "question",
        "type_of_answer",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "survey_id",
        "pvt_org_id",
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
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();

            $result = $this->db->insert('survey_question', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");

            $this->db->where('survey_id', $id);
            $result = $this->db->update('survey_question', $arrData);
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
     * gets events
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get($id = NULL, $row = FALSE) {

        if (!is_null($id))
            $this->db->where('survey_id', $id);
          if ($row) {
            $result = $this->db->get('survey_question')->row();
            return $result;
        } else {
            $result = $this->db->get('survey_question');

            return $result->result_array();
        }
    }


}