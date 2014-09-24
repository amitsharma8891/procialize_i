<?php

class Notification_model extends CI_Model {

    public $limit = '';
    public $notification_type = '';

    function __construct() {
// Initialization of class
        parent::__construct();

        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
        ;
    }

    public $fields = array(
        "id",
        "type",
        "feedback_id",
        "display_time",
        "subject_id",
        "subject_type",
        "object_id",
        "object_type",
        "read",
        "event_id",
        "content",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "pvt_org_id",
        "survey_id",
    );

    function save($data) {
	//echo 'ghfshgdf';
    //echo '<pre>'; print_r($data); 
//echo 'ghfshgdf';
        if ($this->db->insert_batch('notification_user', $data)) {
		//echo $this->db->last_query();exit;
            return true;
        } else {
            return FALSE;
        }
    }

    function update($id, $arrData) {
        $this->db->where_in('id', $id);
        $result = $this->db->update('notification_user', $arrData);
    }

    function save_notification_user($data) {
       // echo '<pre>'; print_r($data); exit;
        if ($this->db->insert('notification_user', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getNotification($type = NULL, $id = NULL, $read = array()) {
        $arrNotification = array();
        $this->db->select('notification_user.*,event.name as event_name');
        if (is_null($type) || is_null($id))
            return $arrNotification;
        if (!empty($read))
            $this->db->where_in('read', $read);
        $this->db->join('event', 'event.id = notification_user.event_id', 'left');
        $this->db->where('subject_id', $id);
        $this->db->where('subject_type', $type);
        $this->db->where('display_time <= ', date("Y-m-d H:i:s"));
        $this->db->order_by('display_time', 'DESC');
        if ($this->limit != '')
            $this->db->limit($this->limit);
        if ($this->notification_type != '')
            $this->db->where_in('type', $this->notification_type);
        $result = $this->db->get('notification_user');

        return $result->result_array();
    }

    function getAll($where){
        $this->db->where($where);
        $result = $this->db->get('notification_user');
        return $result->result_array();
    }
}

?>
