<?php

class exhibitor_profile_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $fields = array(
        "id",
        "website_link",
        "facebook_link",
        "twitter_link",
        "linkedin_link",
        "city",
        "country",
        "location",
        "latitude",
        "longitude",
        "brochure",
        "logo",
        "image1",
        "image2",
        "floor_plan",
        "exhibitor_id"
    );

    /**
     * save
     *
     * saves exhibitor
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
            $result = $this->db->insert('exhibitor_profile', $arrData);
//            $id = $this->db->insert_id();
            $id = $arrData['exhibitor_id'];
        } else {
            $this->db->where('exhibitor_id', $id);
            $result = $this->db->update('exhibitor_profile', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

}
