<?php

class session_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();

        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    public $event_id;
    public $status = array("1","0");
    public $fields = array(
        "id",
        "name",
        "description",
        "start_time",
        "end_time",
        "upload",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "event_id",
//        "speaker_id",
        "track_id",
        "pvt_org_id",
        "session_date",
    );

    public function get($where = NULL) {
        if (!is_null($where))
            $this->db->where($where);
        
        $superadmin = $this->session->userdata('is_superadmin');
        if (!$superadmin)
            $this->db->where('session.event_id', $this->event_id);


        $this->db->where_in('status', $this->status);

        $result = $this->db->get('session');
        return $result->result_array();
    }

    public function getAll($where = NULL) {
        if (!is_null($where))
            $this->db->where($where);
        
        $this->db->select('session.*,
(select group_concat(session_has_attendee.attendee_id) from session_has_attendee where session_id = session.id) as speaker_id            
');
        $superadmin = $this->session->userdata('is_superadmin');
        
        if (!$superadmin)
            $this->db->where('session.event_id', $this->event_id);


        $this->db->where_in('status', $this->status);

        $result = $this->db->get('session');
        return $result->result_array();
    }

    public function getTracks($where = NULL) {
        if (!is_null($where))
            $this->db->where($where);


        $superadmin = $this->session->userdata('is_superadmin');
        if (!$superadmin)
            $this->db->where('track.event_id', $this->event_id);

        $result = $this->db->get('track');
        return $result->result_array();
    }

    public function saveTrack($arrData) {
        $arrData['created_by'] = getCreatedUserId();
        $arrData['status'] = 1;
        $arrData['created_date'] = date("Y-m-d H:i:s");
        $arrData['pvt_org_id'] = getPrivateOrgId();

        $this->db->insert('track', $arrData);
        return true;
    }

    public function deleteTrack($arrData) {
        $this->db->where($arrData);
        $this->db->delete('track');
        return true;
    }
    
    

    function save($data, $id = NULL) {

        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
        if (!isset($arrData['status']))
            $arrData['status'] = 1;

        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();
            $result = $this->db->insert('session', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('session', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

}