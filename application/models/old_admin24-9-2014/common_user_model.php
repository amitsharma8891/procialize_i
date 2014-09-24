<?php

class common_user_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();
    }

    public $limit = NULL;
    public $offset = 0;
    public $event_id = NULL;
    public $attendee_id = NULL;
    public $exhibitor_id = NULL;
    public $organizer_id = NULL;
    public $session_id = NULL;
    public $autocomplete = FALSE;
    public $user_id = NULL;
    public $search = NULL;
    public $from = NULL;
    public $to = NULL;
    public $indsutry = NULL;
    public $functionality = NULL;
    public $location = NULL;
    public $previous_event_id = NULL;
    public $attendee_in_clause = NULL;
    public $event_detail = FALSE;

    /**
     * get
     *
     * gets Events
     * 
     * @author  AMIT SHARMA
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getIndustry($id = NULL, $industry) {
        $query = $this->db
                ->select('id')
                ->from('industry')
                ->where('status', 1);
        if ($industry) {
            $this->db->where("name", $industry);
        }
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    function getFunctionality($id = NULL, $functionality) {
        $query = $this->db
                ->select('id')
                ->from('functionality')
                ->where('status', 1);
        if ($functionality) {
            $this->db->where("name", $functionality);
        }
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    function save_industry_functionality($table, $data) {
        $table_array = array(
            'name' => $data,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
        );

        $this->db->insert($table, $table_array);
        return $this->db->insert_id();
    }

    function save_user($id = NULL, $data) {
        display($data);
        $user_table = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'type_of_user' => 'A',
            'status' => 1,
            'pvt_org_id' => 1,
            'linkden' => $data['likedin_id'],
            'company_name' => $data['company'],
            'designation' => $data['designation'],
        );

        $attendee_table = array(
            'name' => $data['user_table']['first_name'] . ' ' . $data['user_table']['last_name'],
            'location' => $data['location'],
            'city' => $data['city'],
            'country' => $data['country'],
            'photo' => $data['profile_pic'],
            'status' => 1,
            'user_id' => $user_id,
            'attendee_type' => 0,
            'pvt_org_id' => 1,
        );

        if ($id) {
            //update
        } else {
            //insert
            $user_table['created_date'] = data('Y-m-d H:i:s');
            //$this->db->insert('user',$user_table);

            $user_id = $this->db->insert_id();

            $attendee_table['created_date'] = date('Y-m-d H:i:s');
            $attendee_table['user_id'] = $user_id;
        }




        //$this->db->insert('attendee',$attendee_table);
        $attendee_id = $this->db->insert_id();
        if ($data['industry_id']) {
            $industry_table = array(
                'attendee_id' => $attendee_id,
                'industry_id' => $data['industry_id']
            );

            //$this->db->insert('attendee_has_industry',$industry_table);
        }
        if ($data['functionality_id']) {
            foreach ($data['functionality_id'] as $key => $value) {
                $functionality_table = array(
                    'attendee_id' => $attendee_id,
                    'functionality_id' => $value
                );

                //$this->db->insert('attendee_has_functionality',$industry_table);
            }
        }

        return $user_id;
    }

    function getUser() {
        
    }

    function check_user($user_id = NULL, $email) {
        $query = $this->db
                ->select('id,email,status,type_of_user,first_name')
                ->from('user');
        if ($email)
            $this->db->where('email', $email);
        if ($user_id)
            $this->db->where('id', $user_id);

        $query_result = $this->db->get();
        $result = $query_result->result_array();
        //display($result);
        return @$result[0];
    }

    function getUserData($attendee_id) {
        $query = $this->db
                ->select
                        (
                        '(select group_concat(attendee_has_industry.industry_id) from attendee_has_industry where attendee_id = ' . $attendee_id . ') as industry_id,   
                        (select group_concat(attendee_has_functionality.functionality_id) from attendee_has_functionality where attendee_id = ' . $attendee_id . ') as functionality_id,    
                        U_T.first_name,
                        U_T.last_name,
                        U_T.email,
                        U_T.password,
                        U_T.gcm_reg_id,
                        U_T.mobile_os,
                        U_T.type_of_user,
                        U_T.status,
                        U_T.company_name,
                        U_T.designation,
                        U_T.phone,
                        U_T.mobile,
                        A_T.name,
                        A_T.description,
                        A_T.location,
                        A_T.city,
                        A_T.country,
                        A_T.photo,
                        A_T.attendee_type,
                        A_T.website,
                        A_T.subscribe_email,
                        '
                )
                ->from('user as U_T')
                ->join('attendee as A_T', 'A_T.user_id = U_T.id')
                ->where('A_T.id', $attendee_id)
                ->where('A_T.status', 1)
                ->get();
        return $query->row();
    }

    function getOrganizer($organizer_id, $event_id) {
        if ($event_id)
            $this->db->where('E_T.id', $event_id);
        $query = $this->db
                ->select('O_T.name as organizer_name,E_T.name as event_name,U_T.email')
                ->from('event as E_T')
                ->join('organizer as O_T', 'O_T.id = E_T.organizer_id')
                ->join('user as U_T', 'U_T.id = O_T.user_id')
                ->get();
        $query_result = $query->row();
        return $query_result;
    }

    function do_rsvp($session_id, $attendee_id) {
        $table_array = array(
            'session_id' => $session_id,
            'attendee_id' => $attendee_id,
            'pvt_org_id' => 1
        );
        $this->db->insert('session_has_attendee', $table_array);
    }

    function check_rsvp($session_id, $attendee_id) {
        $query = $this->db
                ->select('*')
                ->from('session_has_attendee')
                ->where('attendee_id', $attendee_id)
                ->where('session_id', $session_id)
                ->get();
        return $query->result_array();
    }

    function check_passcode($event_id, $attendee_id, $passcode = NULL) {
        if ($passcode) {
            $this->db->where('E_A.passcode', $passcode);
            $this->db->or_where('E_A.passcode', strtolower($passcode));
            $this->db->or_where('E_A.passcode', strtoupper($passcode));
        } else
            $this->db->where('E_A.status', 1);

        $query = $this->db
                ->select('E_A.attendee_id,E_A.status')
                ->from('event_has_attendee as E_A')
                ->from('attendee as A_T', 'A_T.id = E_A.attendee_id')
                ->where('E_A.event_id', $event_id)
                ->where('E_A.attendee_id', $attendee_id)
                ->get();


        return $query->result_array();
    }

    function getRsvpSession($attendee_id, $tareget_attendee_id, $event_id) {


        $query = $this->db
                ->select('
                        S_A.session_id,
                        S_T.name as session_name,
                        S_T.start_time as session_start_time,
                        S_T.end_time as session_end_time,
                        S_T.session_date,
                        S_A.attendee_id as object_id,
                        S_T.event_id')
                ->from('session_has_attendee as S_A')
                ->join('session as S_T', 'S_T.id = S_A.session_id')
                ->where('(S_A.attendee_id = ' . $attendee_id . ' OR S_A.attendee_id =' . $tareget_attendee_id . ')')
                ->order_by('S_T.session_date')
                ->where('S_T.status', 1)
                ->get();
        $result = $query->result_array();
        if ($result) {
            foreach ($result as $key => $value) {
                $result[$key]['data_type'] = 'session';
            }
        }

        return $result;
    }

    function getSession($session_id = NULL, $event_id = NULL, $speaker_id = NULL) {
        $session_query = $this->db
                ->select(
                        'S_T.id as session_id,
                                                                                         S_T.name as session_name,
                                                                                         S_T.description as session_description,
                                                                                         S_T.start_time as session_start_time,
                                                                                         S_T.end_time as session_end_time,
                                                                                         S_T.session_date,
                                                                                         S_T.event_id,
                                                                                         S_T.upload as session_profile,
                                                                                         S_T.star,
                                                                                         S_T.total as total_user,
                                                                                         SPK_S.id as speaker_id,
                                                                                         SPK_S.name as speaker_name,
                                                                                         SPK_S.description as speaker_description,
                                                                                         SPK_S.speaker_photo,
                                                                                         SPK_S.speaker_profile,
                                                                                         SPK_S.city as speaker_city,
                                                                                         SPK_S.country as speaker_country,
                                                                                         SPK_S.website_link as speaker_website,
                                                                                         SPK_S.user_id,
                                                                                         TRK_T.name as track_name,
                                                                                         '
                ) //S_A.attendee_id,
                ->from('session as S_T')
                ->join('session_has_speaker as S_S', 'S_S.session_id = S_T.id', 'LEFT')
                ->join('speaker as SPK_S', 'SPK_S.id = S_S.speaker_id', 'LEFT')
                ->join('track as TRK_T', 'TRK_T.id = S_T.track_id', 'LEFT')
                ->order_by('S_T.session_date')
                ->where('S_T.status', 1);
        if ($event_id)
            $this->db->where('S_T.event_id', $event_id);

        if ($session_id)
            $this->db->where('S_T.id', $session_id);
        if ($speaker_id)
            $this->db->where('S_T.speaker_id', $speaker_id);

        if ($this->attendee_in_clause) {
            $this->db->where('S_T.id IN (' . implode(',', $this->attendee_in_clause) . ')');
        }

        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }

    function saveFeedback($id, $rating, $feedback_type) {
        $check_feedback = $this->getFeedback($feedback_type, $id);
        if ($feedback_type == 'session') {
            $table_array = array(
                'star' => $check_feedback->star + $rating,
                'total' => $check_feedback->total + 1,
            );
            $this->db->where('id', $id);
            $this->db->update('session', $table_array);
        } else {
            $check_feedback = $this->getFeedback($feedback_type, $id);
            if ($check_feedback) {
                $table_array = array(
                    'star' => $check_feedback->star + $rating,
                    'total' => $check_feedback->total + 1,
                    'modified_date' => date('Y-m-d H:i:s')
                );
                $this->db->where('event_id', $id);
                $this->db->update('event_feedback', $table_array);
            } else {
                $table_array = array(
                    'star' => $rating,
                    'total' => 1,
                    'event_id' => $id,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('event_feedback', $table_array);
            }
        }
    }

    function getFeedback($table, $id) {
        if ($table == 'session')
            $this->db->where('id', $id);
        else
            $this->db->where('event_id', $id);

        $query = $this->db
                ->select('star,total')
                ->from($table)
                ->get();
        return $query->row();
    }

    function add_session_quetion($attendee_id, $session_id, $question) {
        $table_array = array(
            'session_id' => $session_id,
            'attendee_id' => $attendee_id,
            'question' => $question,
            'created_date' => date('Y-m-d H:i:s'),
            'pvt_org_id' => 1,
        );
        $this->db->insert('session_question', $table_array);
        return $this->db->insert_id();
    }

    function push_ad_analytics($object_id, $object_type, $ad_type, $ad_id, $event_id) {
        if ($ad_type == 'normal_ad')
            $ad_type = 'Spo_hit';
        else
            $ad_type = 'Spl_hit';

        $table_array = array(
            'object_type' => $object_type,
            'object_id' => $object_id,
            'subject_type' => 'Sp',
            'subject_id' => $ad_id,
            'type' => $ad_type,
            'created_date' => date('Y-m-d H:i:s'),
            'event_id' => $event_id
        );
        $this->db->insert('analytics', $table_array);
    }

    function saveSocial($data) {

        $msg = '';
        $insert_array = array(
            //'type'                  => $data['type'],
            'display_time' => date('Y-m-d H:i:s'),
            'subject_id' => $data['subject_id'],
            'subject_type' => $data['subject_type'],
            'object_id' => $data['attendee_id'],
            'object_type' => $data['attendee_type'],
            'event_id' => $data['event_id'],
            'read' => 0,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'pvt_org_id' => 1,
        );
        if ($data['transaction_type'] == 'delete') {
            //delete
            $this->db->where('subject_id', $data['subject_id']);
            $this->db->where('object_id', $data['attendee_id']);
            $this->db->where('type', 'Sav');
            $this->db->delete('notification_user');
            $msg = 'Unsaved Successfully!';
        } else {
            if ($data['type'] == 'Sh') {
                $insert_array['type'] = 'Sh';
                $msg = 'Shared Successfully!';
            } else {
                $insert_array['type'] = 'Sav';
                $msg = 'Saved Successfully!';
            }

            $this->db->insert('notification_user', $insert_array);
        }

        return $msg;
    }

    function checkAttendee($event_id, $attendee_id) {
        $query = $this->db
                ->select('passcode')
                ->from('event_has_attendee as E_A')
                ->where('E_A.attendee_id', $attendee_id)
                ->where('E_A.event_id', $event_id)
                ->get();

        return $query->result_array();
    }

    function insert_attendee($event_id, $attendee_id) {
        $passcode = generatePassword(6);
        $table_array = array(
            'event_id' => $event_id,
            'attendee_id' => $attendee_id,
            'status' => 0,
            'passcode' => $passcode,
            'pvt_org_id' => 1,
        );
        $this->db->insert('event_has_attendee', $table_array);
        return $passcode;
    }

}

?>
