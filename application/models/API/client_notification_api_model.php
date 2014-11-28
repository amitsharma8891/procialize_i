<?php

class client_notification_api_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();
    }

    public $subject_id = NULL;
    public $count = FALSE;
    public $subject_type = 'A';
    public $type = NULL;
    public $read = NULL;
    public $event_id = NULL;
    public $notification_type = NULL;
    public $order_by = 'DESC';
    public $activity_flag = FALSE;
    public $attendee_type = NULL;

    function notificationCount($subject_id) {
        //echo $subject_id;
        if ($subject_id) {
            $query = $this->db
                    ->select('COUNT(distinct id) as total_notification')
                    ->from('notification_user')
                    ->where('subject_id', $subject_id)
                    ->where('read', 0)
                    ->get();
            $result = $query->result_array();
            //display($result);
            return @$result[0]['total_notification'];
        } else {
            return 0;
        }
    }

    function getNotification($notification_id = NULL, $order_by = 'DESC') {
        $query = $this->db
                ->select(
                        'N_U.id as notification_id,
                                                                                         N_U.type as notification_type,
                                                                                         N_U.subject_id,
                                                                                         N_U.subject_type,
                                                                                         N_U.object_id,
                                                                                         N_U.object_type,
                                                                                         N_U.read ,
                                                                                         N_U.content as notification_content,
                                                                                         N_U.meeting_id,
                                                                                         N_U.message_id,
                                                                                         N_U.event_id,
                                                                                         N_U.display_time as notification_date,
                                                                                         U_T.id as user_id,
                                                                                         U_T.first_name,
                                                                                         U_T.last_name,
                                                                                         U_T.type_of_user,
                                                                                         A_T.company_name,
                                                                                         A_T.designation,
                                                                                         A_T.phone,
                                                                                         M_T.approve,
                                                                                         M_T.start_time,
                                                                                         M_T.end_time,
                                                                                         E_T.name as event_name,
                                                                                         A_T.id as attendee_id,
                                                                                         A_T.name as attendee_name,
                                                                                         O_T.name as organizer_name,
                                                                                         EF_T.id as feedback_id,
                                                                                         EF_T.star as event_star,
                                                                                         EF_T.total as event_total_user,
                                                                                         SUR_T.name as survey_name,
                                                                                         SUR_T.url as survey_url
                                                                                         '
                )
                ->from('notification_user as N_U')
                ->join('event as E_T', 'E_T.id = N_U.event_id', 'LEFT')
                ->join('attendee as A_T', 'A_T.id = N_U.object_id', 'LEFT')
                ->join('user as U_T', 'U_T.id = A_T.user_id', 'LEFT')
                ->join('organizer as O_T', 'O_T.id = N_U.object_id', 'LEFT')
                //-> join('exhibitor as EX_T','EX_T.contact_id = N_U.object_id','LEFT')
                ->join('meeting as M_T', 'M_T.id = N_U.meeting_id', 'LEFT')
                ->join('event_feedback as EF_T', 'EF_T.id = N_U.feedback_id', 'LEFT')
                ->join('survey as SUR_T', 'SUR_T.id = N_U.survey_id', 'LEFT');

        if (!is_null($this->read))
            $this->db->where('N_U.read', $this->read);


        if ($this->subject_id)
            $this->db->where('N_U.subject_id', $this->subject_id);

        if ($this->notification_type) {
            switch ($this->notification_type) {
                case 'A':
                    break;
                case 'N':
                    $this->db->where('N_U.type', 'N');
                    break;
                case 'E':
                    break;
                case 'O':
                    break;
                case 'Mtg':
                    $this->db->where('N_U.type', 'Mtg');
                    $this->db->where('N_U.id', $notification_id);
                    break;
                case 'F':
                    $this->db->where('N_U.type', 'F');
                    $this->db->where('N_U.feedback_id', $notification_id);
                    $this->db->order_by('N_U.display_time', $this->order_by);
                    //$this->db->join('event_feedback as EF_T','EF_T.id = N_U.feedback_id');
                    break;
                case 'Msg':
                    $this->order_by = 'ASC';
                    $this->db->where('N_U.message_id', $notification_id);
                    $this->db->order_by('N_U.display_time', $this->order_by);
                    break;
            }
        }
        $this->db->order_by('N_U.display_time', $this->order_by);


        $query_result = $this->db->get();
        $result = $query_result->result_array();
        //show_query();exit;
        //display($result);
        foreach ($result as $key => $val) {


            $query2 = $this->db
                    ->select('U_T.id as user_id,
                                                                                         U_T.first_name,
                                                                                         U_T.last_name,
                                                                                         U_T.type_of_user
                                                                                         ')
                    ->from('user as U_T');
            if ($val['subject_type'] == 'A') {
                $this->db->select('A_T.company_name,A_T.designation,A_T.phone');
                $this->db->join('attendee as A_T', 'A_T.user_id = U_T.id');
                $this->db->where('A_T.id', $val['subject_id']);
            } elseif ($val['subject_type'] == 'E') {
                $this->db->join('exhibitor as E_T', 'E_T.contact_id = U_T.id');
                $this->db->where('E_T.id', $val['subject_id']);
            } elseif ($val['subject_type'] == 'O') {
                $this->db->join('organizer as O_T', 'O_T.user_id = U_T.id');
                $this->db->where('O_T.id', $val['subject_id']);
            }

            $query_result2 = $this->db->get();
            $value = $query_result2->result_array();
            $result[$key]['receiver_data'] = @$value[0];
        }
        return $result;
    }

    function getwallNotification($notification_id = NULL, $order_by = 'DESC') {
        $query = $this->db
                ->select(
                        'N_U.id as notification_id,
                                                                                         N_U.type as notification_type,
                                                                                         N_U.subject_id,
                                                                                         N_U.subject_type,
                                                                                         N_U.object_id,
                                                                                         N_U.object_type,
                                                                                         N_U.read ,
                                                                                         N_U.content as notification_content,
                                                                                         N_U.meeting_id,
                                                                                         N_U.message_id,
                                                                                         N_U.event_id,
                                                                                         N_U.display_time as notification_date,
                                                                                         U_T.id as user_id,
                                                                                         U_T.first_name,
                                                                                         U_T.last_name,
                                                                                         U_T.type_of_user,
                                                                                         A_T.company_name,
                                                                                         A_T.designation,
                                                                                         A_T.phone,
                                                                                         E_T.name as event_name,
                                                                                         A_T.id as attendee_id,
                                                                                         A_T.name as attendee_name,
                                                                                         O_T.name as organizer_name,
                                                                                         EF_T.id as feedback_id,
                                                                                         EF_T.star as event_star,
                                                                                         EF_T.total as event_total_user'
                )
                ->from('notification_user as N_U')
                ->join('event as E_T', 'E_T.id = N_U.event_id', 'LEFT')
                ->join('attendee as A_T', 'A_T.id = N_U.object_id', 'LEFT')
                ->join('user as U_T', 'U_T.id = A_T.user_id', 'LEFT')
                ->join('organizer as O_T', 'O_T.id = N_U.object_id', 'LEFT')
                //-> join('exhibitor as EX_T','EX_T.contact_id = N_U.object_id','LEFT')
//                ->join('meeting as M_T', 'M_T.id = N_U.meeting_id', 'LEFT')
                ->join('event_feedback as EF_T', 'EF_T.id = N_U.feedback_id', 'LEFT');
//                ->join('survey as SUR_T', 'SUR_T.id = N_U.survey_id', 'LEFT');

        if (!is_null($this->read))
            $this->db->where('N_U.read', $this->read);
        $this->db->where('N_U.event_id', 1);
        $notification_type = array('Msg', 'Mtg', 'S','Passcode');
        $this->db->where_not_in('N_U.type', $notification_type);
        $this->db->order_by('N_U.created_date', 'DESC');

        $query_result = $this->db->get();
        $result = $query_result->result_array();
        //show_query();exit;
        //display($result);
        foreach ($result as $key => $val) {
            $query2 = $this->db
                    ->select('U_T.id as user_id,
                              U_T.first_name,
                              U_T.last_name,
                              U_T.type_of_user
                             ')
                    ->from('user as U_T');
            if ($val['subject_type'] == 'A') {
                $this->db->select('A_T.company_name,A_T.designation,A_T.phone');
                $this->db->join('attendee as A_T', 'A_T.user_id = U_T.id');
                $this->db->where('A_T.id', $val['subject_id']);
            } elseif ($val['subject_type'] == 'E') {
                $this->db->join('exhibitor as E_T', 'E_T.contact_id = U_T.id');
                $this->db->where('E_T.id', $val['subject_id']);
            } elseif ($val['subject_type'] == 'O') {
                $this->db->join('organizer as O_T', 'O_T.user_id = U_T.id');
                $this->db->where('O_T.id', $val['subject_id']);
            }
            $query_result2 = $this->db->get();
            $value = $query_result2->result_array();
            $result[$key]['receiver_data'] = @$value[0];
        }
        return $result;
    }

    function update_notification_status($subject_id) {
        $table_array = array('read' => 1);
        $this->db->where('subject_id', $subject_id);
        $this->db->update('notification_user', $table_array);
    }

    function get_notification_list($subject_id) {
        $table_array = array('read' => 1);
        $this->db->where('subject_id', $subject_id);
        $this->db->order_by('created_date', 'DESC');
        $this->db->update('notification_user', $table_array);
    }

    function getSocialMessage($attendee_id, $event_id) {
        if ($this->activity_flag)
            $this->db->where('N_U.object_id', $attendee_id);
        elseif ($this->attendee_type) {
            $this->db->where('N_U.object_id', $attendee_id);
            $this->db->where('N_U.subject_type', $this->attendee_type);
            $this->db->where('N_U.type', 'Sav');
        } else
            $this->db->where('((N_U.type = "Msg" AND N_U.subject_id = 0) OR N_U.type = "Sav" OR N_U.type = "Sh")');


        if ($this->notification_type)
            $this->db->where('N_U.type', $this->notification_type);

        if ($event_id)
            $this->db->where('N_U.event_id', $event_id);

        $query = $this->db
                ->select(
                        'N_U.id as notification_id,
                                                                                         N_U.type as notification_type,
                                                                                         N_U.subject_id,
                                                                                         N_U.subject_type,
                                                                                         N_U.object_id,
                                                                                         N_U.object_type,
                                                                                         N_U.read ,
                                                                                         N_U.content as notification_content,
                                                                                         N_U.meeting_id,
                                                                                         N_U.message_id,
                                                                                         N_U.event_id,
                                                                                         N_U.display_time as notification_date,
                                                                                         U_T.id as user_id,
                                                                                         U_T.first_name,
                                                                                         U_T.last_name,
                                                                                         U_T.type_of_user,
                                                                                         A_T.company_name,
                                                                                         A_T.designation,
                                                                                         A_T.phone,
                                                                                         A_T.name,
                                                                                         E_T.name as event_name,
                                                                                         '
                )
                ->from('notification_user as N_U')
                ->join('event as E_T', 'E_T.id = N_U.event_id', 'LEFT')
                ->join('attendee as A_T', 'A_T.id = N_U.object_id')
                ->join('user as U_T', 'U_T.id = A_T.user_id')
                ->order_by('N_U.created_date', 'DESC')
                ->get();
        //show_query();exit;
        $result = $query->result_array();
        //show_query();exit;
        if ($result) {
            foreach ($result as $key => $val) {
                $query2 = $this->db
                        //-> distinct()
                        ->select('U_T.id as user_id,
                                                                                             U_T.email as exhibitor_email,
                                                                                             U_T.first_name,
                                                                                             U_T.last_name,
                                                                                             U_T.type_of_user
                                                                                             ')
                        ->from('user as U_T');
                if ($val['subject_type'] == 'A' || $val['subject_type'] == 'S') {
                    $this->db->select('
                                    A_T.id as target_id,A_T.attendee_type,A_T.name,A_T.photo as attendee_image,A_T.location as attendee_location,A_T.city as attendee_city,A_T.country as attendee_country,A_T.company_name,A_T.designation,A_T.phone,
                                    A_T.id as attendee_id,
                                    A_T.industry as attendee_industry,
                        A_T.functionality as attendee_functionality'
//                    (select group_concat(industry.name) from attendee_has_industry INNER JOIN industry ON industry.id = attendee_has_industry.industry_id where attendee_id = A_T.id ) as attendee_industry,
//                    (select group_concat(functionality.name) from attendee_has_functionality INNER JOIN functionality ON functionality.id = attendee_has_functionality.functionality_id where attendee_id = A_T.id ) as attendee_functionality,
                    );
                    $this->db->join('attendee as A_T', 'A_T.user_id = U_T.id');
                    $this->db->where('A_T.id', $val['subject_id']);
                } elseif ($val['subject_type'] == 'E') {
                    //echo '247';
                    $this->db->select('
                    EX_T.name,
                    A_T.id as target_id,
                    A_T.id as attendee_id,
                    A_T.attendee_type,
                    EX_T.id as exhibitor_id,
                    EX_T.name as exhibitor_name,
                    EX_P.city as exhibitor_city,
                    EX_P.country as exhibitor_country,
                    EX_T.is_featured as exhibitor_featured,
                    EX_T.stall_number,
                    EX_P.logo as exhibitor_logo,
                    A_T.industry as exhibitor_industry,
                    A_T.functionality as exhibitor_functionality'
//                    (select group_concat(industry.name) from exhibitor_has_industry INNER JOIN industry ON industry.id = exhibitor_has_industry.industry_id where exhibitor_id = EX_T.id ) as exhibitor_industry,
//                    (select group_concat(functionality.name) from exhibitor_has_functionality INNER JOIN functionality ON functionality.id = exhibitor_has_functionality.functionality_id where exhibitor_id = EX_T.id ) as exhibitor_functionality
                    );
                    //$this->db->select('E_T.id as target_id, E_T.name');
                    $this->db->join('attendee as A_T', 'A_T.user_id = U_T.id');
                    $this->db->join('exhibitor as EX_T', 'EX_T.contact_id = A_T.user_id');
                    $this->db->join('exhibitor_profile as EX_P', 'EX_P.exhibitor_id = EX_T.id');
                    $this->db->where('A_T.id', $val['subject_id']);
                } elseif ($val['subject_type'] == 'Event') {
                    //echo 'safd';
                    $this->db->select('E_T.id as target_id, E_T.name');
                    $this->db->join('attendee as A_T', 'A_T.user_id = U_T.id');
                    $this->db->join('event_has_attendee as E_A', 'E_A.attendee_id = A_T.id');

                    $this->db->join('event as E_T', 'E_T.id = E_A.event_id');
                    $this->db->where('E_T.id', $val['subject_id']);
                } elseif ($val['subject_type'] == 'O') {
                    $this->db->select('O_T.name');
                    $this->db->join('organizer as O_T', 'O_T.user_id = U_T.id');
                    $this->db->where('O_T.id', $val['subject_id']);
                }

                $query_result2 = $this->db->get();
                $value = $query_result2->result_array();
                //show_query();
                $result[$key]['receiver_data'] = @$value[0];
            }
        }
        //display($result);exit;
        return $result;
    }

    function checkSavedShared($subject_id, $attndee_id, $type) {
        $query = $this->db
                ->select('id')
                ->from('notification_user')
                ->where('type', $type)
                ->where('subject_id', $subject_id)
                ->where('object_id', $attndee_id)
                ->get();
        return $query->row();
    }

    function saveSocial($data) {
        $msg = '';
        $insert_array = array(
            'type' => $data['type'],
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
                ->select('star, total')
                ->from($table)
                ->get();
        return $query->row();
    }

    function getMeeting($meeting_id) {
        $query = $this->db
                ->select()
                ->from('meeting')
                ->where('id', $meeting_id)

                //-> order_by('view_count','ASC')
                ->get();
        //show_query();
        return $query->row();
    }

    function getNormalAd($event_id) {
        $query = $this->db
                ->select('name, normal_ad, splash_ad, link, status, user_id, event_id')
                ->from('sponser')
                ->where('event_id', $event_id)
                //-> order_by('view_count','ASC')
                ->get();
        //show_query();
        return $query->result_array();
    }

    function push_analytics($type, $object_id, $object_type, $subject_id, $subject_type, $event_id) {
        if ($type == 'download') {
            if ($subject_type == 'Event')
                $type = 'download_evt_map';
            elseif ($subject_type == 'Session')
                $type = 'download_ses_map';
            elseif ($subject_type == 'E')
                $type = 'download_exe_map';
            elseif ($subject_type == 'S')
                $type = 'download_spe_map';
        }


        $insert_array = array(
            'object_id' => $object_id,
            'object_type' => $object_type,
            'subject_id' => $subject_id,
            'subject_type' => $subject_type,
            'type' => $type,
            'created_date' => date('Y-m-d H:i:s'),
            'event_id' => $event_id,
            'pvtorgid' => 1,
        );
        $this->db->insert('analytics', $insert_array);
    }

    function socialNotificationCount($attendee_id, $event_id) {
        $query = $this->db
                ->select('*')
                ->from('event_has_attendee')
                ->where('rightside_social_notification', 0)
                ->where('attendee_id', $attendee_id)
                ->where('event_id', $event_id)
                ->get();
        $result = $query->result_array();
        //show_query();exit;
        //display($result);
        return $result;
    }

    function app_sync_flag($attendee_id) {
        $query = $this->db
                ->select('last_app_sync_time')
                ->from('attendee')
                ->where('id', $attendee_id)
                ->get();
        return $query->row();
    }

}
