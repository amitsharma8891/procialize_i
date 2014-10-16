<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard_model
 *
 * @author AATISH
 */
class dashboard_model extends CI_Model {

    public $object = NULL;
    public $event_id;

    function __construct() {
// Initialization of class
        parent::__construct();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    public function getAll($arrWhere = array()) {
        if (!empty($arrWhere))
            $this->db->where($arrWhere);
        $result = $this->db->get('analytics');
        //show_query();
        return $result->result_array();
        
    }

    public function getDistinctEventView($arrWhere) {
        if (!empty($arrWhere))
            $this->db->where('AN_T.event_id', $arrWhere);

        $this->db->where('subject_type', 'Event');
        $this->db->where('type', 'view');
        $this->db->distinct();
        $this->db->select('AN_T.object_id');
        $this->db->join('attendee as A_T', 'A_T.id = AN_T.object_id');
        $this->db->join('event_has_attendee as E_A', ' E_A.attendee_id = A_T.id');
        $result = $this->db->get('analytics as AN_T');
        //show_query();
        return $result->result_array();
    }

    public function getAttendee($event_id = NULL) {
        $this->db->where('event_id', (is_null($event_id) ? $this->event_id : $event_id));
        $result = $this->db->get('event_has_attendee');
        return $result->result_array();
    }

    function getAppAttendee() {
        $this->db->where("U_T.gcm_reg_id <> ''");
        $this->db->where('event_id', (is_null($event_id) ? $this->event_id : $event_id));
        $result = $this->db->get('user');
        return $result->result_array();
    }

    public function getMeeting($event_id = NULL) {
        $this->db->where('event_id', (is_null($event_id) ? $this->event_id : $event_id));
        $this->db->join('meeting', 'meeting.id = notification_user.meeting_id');
        $result = $this->db->get('notification_user');
        return $result->result_array();
    }

    public function getMeetingExh($event_id = NULL) {
        $type = $this->session->userdata('type_of_user');
        $user_id = $this->session->userdata('user_id');
        $this->db->where('event_id', (is_null($event_id) ? $this->event_id : $event_id));
        $this->db->join('meeting', 'meeting.id = notification_user.meeting_id');
        $this->db->where('notification_user.object_id', $user_id);
        $this->db->where('notification_user.object_type', $type);

        $result = $this->db->get('notification_user');
        return $result->result_array();
    }

    public function getNotInfo($col = 'object', $not_type = "Msg") {
        $this->db->select('count(*) as cnt');
        $type = $this->session->userdata('type_of_user');
        $user_id = $this->session->userdata('user_id');

        if ($this->event_id != '')
            $this->db->where('event_id', $this->event_id);

        if ($not_type = 'Mtg')
            $this->db->join('meeting', 'meeting.id = notification_user.meeting_id');

        $this->db->where('notification_user.' . $col . '_id', $user_id);
        $this->db->where('notification_user.' . $col . '_type', $type);
        $this->db->where('notification_user.' . 'type', $not_type);

        $result = $this->db->get('notification_user')->row();
        return $result;
    }

    public function getSession($event_id = NULL) {
        $this->db->select('session.name , session.star , session.total');
        $this->db->select('(select count(*) from session_has_attendee join attendee ON attendee.id = session_has_attendee.attendee_id where session_has_attendee.session_id = session.id and (attendee.attendee_type = "A" OR attendee.attendee_type = "E")) as session_attendees');
        $this->db->select('(select count(*) from session_has_speaker where session_id = session.id) as session_speaker');
        $this->db->select('(select count(*) from session_question where session_id = session.id) as session_question');
        $this->db->where('event_id', (is_null($event_id) ? $this->event_id : $event_id));
        $result = $this->db->get('session');
        return $result->result_array();
    }

    public function getAttendeeInterest($table = 'industry', $is_speaker = false) {

        if ($table != 'industry' && $table != 'functionality') {
            $column = 'attendee.' . $table;
            $join = false;
        } else {
            $column = $table . '.name';
            $join = true;
        }
        if ($is_speaker)
            $attendee_type = "'S'";
        else
            $attendee_type = "'A', 'E'";

        $query = "SELECT count(attendee.id) as cnt,$column as display_name
            FROM (`attendee`) 
            LEFT JOIN `user` ON `user`.`id` = `attendee`.`user_id` 
            JOIN `event_has_attendee` ON `event_has_attendee`.`attendee_id` = `attendee`.`id` 
            LEFT JOIN `event` ON `event_has_attendee`.`event_id` = `event`.`id` 
            LEFT JOIN `event_profile` ON `event_profile`.`event_id` = `event`.`id` 
            LEFT JOIN `organizer` ON `organizer`.`id` = `event`.`organizer_id`";
        if ($join) {
            $query .="JOIN attendee_has_$table ON attendee_has_$table.attendee_id = `attendee`.`id` 
            JOIN $table ON $table.id = attendee_has_$table.{$table}_id ";
        }
        $query .= "WHERE `event_has_attendee`.`event_id` = '$this->event_id' AND `attendee_type` IN ($attendee_type) AND `event`.`id` = '$this->event_id' 
            GROUP BY $column
        ";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getExhibitorInterest($table = 'industry') {
        if ($table != 'industry' && $table != 'functionality') {
            $column = 'exhibitor_profile.' . $table;
            $join = false;
        } else {
            $column = $table . '.name';
            $join = true;
        }

        $query = "SELECT 
count(exhibitor.id) as cnt,$column as display_name
FROM (`exhibitor`) 
JOIN `exhibitor_profile` ON `exhibitor_profile`.`exhibitor_id` = `exhibitor`.`id` 
JOIN `user` user2 ON `exhibitor`.`user_id` = `user2`.`id` 
LEFT JOIN `event` ON `exhibitor`.`event_id` = `event`.`id` 
LEFT JOIN `event_profile` ON `event_profile`.`event_id` = `event`.`id` 
LEFT JOIN `organizer` ON `event`.`organizer_id` = `organizer`.`id` 
JOIN `user` ON `exhibitor`.`contact_id` = `user`.`id` 
JOIN `attendee` ON `user`.`id` = `attendee`.`user_id` ";
        if ($join) {
            $query .= "JOIN exhibitor_has_$table ON exhibitor_has_$table.exhibitor_id = `exhibitor`.`id` 
JOIN $table ON $table.id = exhibitor_has_$table.{$table}_id";
        }
        $query .= " JOIN `event_has_attendee` ON `attendee`.`id` = `event_has_attendee`.`attendee_id` AND event_has_attendee.event_id = event.id 
WHERE `event`.`id` = $this->event_id AND `exhibitor`.`event_id` = $this->event_id
AND `exhibitor`.`status` IN ('1', '0') 
GROUP BY $column ";

        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getCount($table, $where = NULL) {
        $this->db->select('count(*) cnt');
        if (!is_null($where))
            $this->db->where($where);
        $result = $this->db->get($table);
        return $result->result_array();
    }

}

?>
