<?php


class event_profile_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $fields = array(
        "id",
        "city",
        "country",
        "location",
        "latitude",
        "longitude",
        "website",
        "linkden",
        "twitter",
        "facebook",
        "logo",
		"floor_plan",
        "image1",
        "image2",
        "image3",
        "contact_name",
        "contact_lastname",
        "contact_email",
        "contact_mobile",
        "contact_phone",
        "event_id"
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
		// var_dump($arrData); die;
        if (is_null($id)) {
            $result = $this->db->insert('event_profile', $arrData);
//            $id = $this->db->insert_id();
            $id = $arrData['event_id'];
        } else {
		
            $this->db->where('event_id', $id);
            $result = $this->db->update('event_profile', $arrData);
			// echo  $this->db->last_query(); die;
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

}
