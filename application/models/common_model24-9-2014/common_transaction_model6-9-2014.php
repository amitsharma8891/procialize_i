<?php

class common_transaction_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $message_id = NULL;
    public $message = NULL;
    public $event_id = NULL;
    public $reply = FALSE;
    public $broadcast_msg = NULL;
    public $call_type = NULL;
    public $meeting_id = NULL;
    public $meeting_start_time = NULL;
    public $meeting_end_time = NULL;
    public $meeting_responce = NULL;

    /*
      $object_id : logged in user
      $object_type : logged in user type
      $object_name : logged in user name
     * $organizer_data : organizer data against event
     * $subject_id : the target user
     *      */

    function common_send_message($type, $user_data, $event_id, $subject_id, $subject_type) {
        //echo 'model--->'.$subject_id.$subject_type;
        $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        $get_target_attendee = $this->common_user_model->getUserData($subject_id);
        //display($organizer_data);
//        display($get_target_attendee);
        $email_template = get_email_template('send message email Info');
        $keywords = array('{app_name}', '{event_name}', '{subject_first_name}', '{first_name}', '{object_first_name}', '{msg_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}');
        $replace_with = array(
            $email_template['setting']['app_name'],
            $organizer_data->event_name,
            $get_target_attendee->first_name,
            $user_data->first_name,
            $user_data->first_name . ',' . $user_data->company_name,
            $this->message,
            $email_template['setting']['app_contact_email'],
            SITE_URL,
            CLIENT_IMAGES,
            $email_template['setting']['app_logo_big'],
        );
        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
        $html = str_replace($keywords, $replace_with, $email_template['body']);
        $to = $get_target_attendee->email;
        if ($this->message_id)
            $message_id = $this->message_id;
        else
            $message_id = $this->getMessageCounter($user_data->attendee_id, $subject_id);
        $message_id = md5($message_id->message_count);

        //$this->model->single_msg = TRUE;
        $send_msg = $this->send_message($user_data->attendee_id, $user_data->attendee_type, $message_id, $subject_id, $subject_type, $this->message, $this->event_id);
        //show_query();
        if ($get_target_attendee->gcm_reg_id && !$this->broadcast_msg) {
            //echo 'model 53  mmnjjkkhf'.$get_target_attendee->gcm_reg_id;
            $mobile_message = $user_data->first_name . ' ' . bracket_attendee_attribute($user_data->designation, $user_data->company_name, '-') . ' sent you a message';
            $responce = $this->mobile_model->send_notification($get_target_attendee->gcm_reg_id, $get_target_attendee->mobile_os, $mobile_message);
            //echo 'dsafsdfsddgdgdfg'.$responce;
        }
//        $to = "anupam.bhatnagar@infiniteit.biz";
        if (check_DND($subject_id) && !$this->broadcast_msg)
            sendMail($to, $subject, '', $html);
        return $send_msg;
    }

    function send_message($attendee_id, $attendee_type, $message_id, $subject_id, $subject_type, $message, $event_id) {
        $table_array = array(
            'message_id' => $message_id,
            'type' => 'Msg',
            'display_time' => date('Y-m-d H:i:s'),
            'object_id' => $attendee_id,
            'object_type' => $attendee_type,
            'event_id' => $event_id,
            'read' => 0,
            'content' => $message,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s')
        );
        //display($table_array);
        if ($this->broadcast_msg) {
            $table_array['subject_id'] = 0;
            $table_array['subject_type'] = 0;
        } else {
            $table_array['subject_id'] = $subject_id;
            $table_array['subject_type'] = $subject_type;
        }


        $this->db->insert('notification_user', $table_array);
        //echo show_query();
        return $this->db->insert_id();
    }

    function getMessageCounter($attendee_id, $target_attendee_id) {
        $check_message_query = $this->db
                ->select('message_id as message_count')
                ->from('notification_user')
                ->where_not_in('message_id', 0)
                ->where('type', 'Msg')
                ->where("((subject_id = $attendee_id AND object_id = $target_attendee_id) OR (subject_id = $target_attendee_id  AND object_id = $attendee_id))")
                ->get();
        $query_result = $check_message_query->row();
        if ($query_result)
            return $query_result;



        $query = $this->db
                ->select('message_count')
                ->from('message_counter')
                ->get();
        $result = $query->row();
        $this->db->update('message_counter', array('message_count' => $result->message_count + 1));
        //display($result);

        return $result;
    }

    function common_set_meeting($type, $user_data, $event_id, $subject_id, $subject_type) {
        $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        $get_target_attendee = $this->common_user_model->getUserData($subject_id);
        $check_slot = $this->check_slot($subject_id, $event_id, $this->meeting_start_time, $this->meeting_end_time);
        if ($check_slot && $type == 'set')
            return array('check_slot' => $check_slot, 'set_meeting' => '', 'reply_meeting' => '');
        if ($type == 'set') {
            $reply_meeting = '';
            $set_meeting = $this->set_meeting($user_data->attendee_id, $user_data->attendee_type, $subject_id, $subject_type, $event_id, $this->message, $this->meeting_start_time, $this->meeting_end_time);
        } else {
            $set_meeting = '';
            $reply_meeting = $this->reply_meeting($user_data->attendee_id, $user_data->attendee_type, $subject_id, $subject_type, $event_id, $this->message, $this->meeting_id);
        }
        $to = $get_target_attendee->email;
        //MAIL TEMLATE
        $email_template = get_email_template('mail for setup meeting');
        $keywords = array('{app_name}', '{event_name}', '{meeting_date}', '{meeting_time}', '{subject_first_name}', '{object_first_name}', '{msg_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}');
        $replace_with = array(
            $email_template['setting']['app_name'],
            $organizer_data->event_name,
            date('d M Y', strtotime($this->meeting_start_time)),
            date('h .i A', strtotime($this->meeting_end_time)),
            $get_target_attendee->first_name,
            $user_data->first_name . ',' . $user_data->company_name,
            $this->message,
            $email_template['setting']['app_contact_email'],
            SITE_URL,
            CLIENT_IMAGES
        );
        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
        $html = str_replace($keywords, $replace_with, $email_template['body']);

        //MAIL TEMLATE CLOSE

        if ($get_target_attendee->gcm_reg_id) {

            $mobile_message = $user_data->first_name . ' ' . bracket_attendee_attribute($user_data->designation, $user_data->company_name, '-') . ' sent you a meeting request.';
            $responce = $this->mobile_model->send_notification($get_target_attendee->gcm_reg_id, $get_target_attendee->mobile_os, $mobile_message);
            //echo $responce;
        }
        if (check_DND($subject_id))
            sendMail($to, $subject, '', $html);
        return array('check_slot' => '', 'set_meeting' => $set_meeting, 'reply_meeting' => $reply_meeting);
    }

    function check_slot($subject_id, $event_id, $start_time, $end_time) {
        $query = $this->db
                ->select('M_T.id')
                ->from('meeting as M_T')
                ->join('notification_user as N_U', 'N_U.meeting_id = M_T.id')
                ->where('N_U.event_id', $event_id)
                //->where('(object_id = ' . $subject_id . ' OR subject_id =' . $subject_id . ' )')
                //-> or_where('subject_id',$target_id)
                //-> where('start_time',$start_time)
                //-> where('end_time',$end_time)
                ->where('(start_time >= "' . $start_time . '" AND end_time <= "' . $end_time . '")')
                ->where('approve', 1)
                ->get();
        $meeting_result = $query->row();
        //show_query();
        if ($meeting_result)
            return $meeting_result;

        $query2 = $this->db
                ->select('S_A.session_id')
                ->from('session_has_attendee as S_A')
                ->join('session as S_T', 'S_T.id = S_A.session_id')
                ->where('S_A.attendee_id ', $subject_id)
                //->where('S_T.event_id ', $event_id)
                ->where('(S_T.start_time >= "' . $start_time . '" AND S_T.end_time <="' . $end_time . '")')
                ->order_by('S_T.session_date')
                ->where('S_T.status', 1)
                ->get();
        $result = $query2->row();
        //show_query();
        return $result;
    }

    function set_meeting($object_id, $object_type, $subject_id, $subject_type, $event_id, $message, $start_time, $end_time) {
        $meeting_table = array(
            'subject_id' => $subject_id,
            'subject_type' => $subject_type,
            'object_id' => $object_id,
            'object_type' => $object_type,
            'message' => $message,
            'approve' => 0,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'pvt_org_id' => 1,
        );
        $this->db->insert('meeting', $meeting_table);
        $meeting_id = $this->db->insert_id();

        $notification_table = array(
            'meeting_id' => $meeting_id,
            'type' => 'Mtg',
            'display_time' => date('Y-m-d H:i:s'),
            'subject_id' => $subject_id,
            'subject_type' => $subject_type,
            'object_id' => $object_id,
            'object_type' => $object_type,
            'event_id' => $event_id,
            'read' => 0,
            'content' => $message,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'pvt_org_id' => 1,
        );
        $this->db->insert('notification_user', $notification_table);
        return $this->db->insert_id();
    }

    function reply_meeting($object_id, $object_type, $subject_id, $subject_type, $event_id, $message, $meeting_id) {

        $msg = '';
        $notification_table = array(
            'type' => 'Mtg',
            'meeting_id' => $meeting_id,
            'display_time' => date('Y-m-d H:i:s'),
            'subject_id' => $subject_id,
            'subject_type' => $subject_type,
            'object_id' => $object_id,
            'object_type' => $object_type,
            'event_id' => $event_id,
            'read' => 0,
            'content' => $message,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'pvt_org_id' => 1,
        );
        if ($this->meeting_responce == 'approve') {
            //update
            $query = $this->db->get_where('meeting', array('id' => $meeting_id, 'approve' => 1));
            $get_meeting = $query->row();
            //display($get_meeting);
            if ($get_meeting) {
                $msg = 'This slot is already booked';
                return $msg;
            } else {
                $this->db->where('id', $meeting_id);
                $this->db->update('meeting', array('approve' => 1));
                $msg = 'Meeting Set Successfully!';
            }
        } elseif ($this->meeting_responce == 'decline') {
            $msg = 'You declined Successfully';
            $this->db->where('id', $meeting_id);
            $this->db->update('meeting', array('approve' => 2));
            //show_query();
        }
        $this->db->insert('notification_user', $notification_table);
        return $msg;
    }

    function common_do_rsvp($user_data, $event_id, $session_id) {
        $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        $get_session = $this->common_user_model->getSession($session_id);
        $check_rsvp = $this->common_user_model->check_rsvp($session_id, $user_data->attendee_id);
        $success_array = array('error' => 'error', 'msg' => 'something went wrong');
        if (!$check_rsvp) {
            $rsvp = $this->common_user_model->do_rsvp($session_id, $user_data->attendee_id);
            $to = $organizer_data->email; //$this->session->userdata('client_email');
            //MAIL TEMLATE
            $email_template = get_email_template('mail to organizer when Attendee rsvp');
            $keywords = array('{app_name}', '{session_name}', '{org_name}', '{first_name}', '{email}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}');
            $replace_with = array(
                $email_template['setting']['app_name'],
                @$get_session[0]['session_name'],
                $organizer_data->organizer_name,
                $user_data->first_name,
                $user_data->email,
                $email_template['setting']['app_contact_email'],
                SITE_URL,
                CLIENT_IMAGES
            );
            $subject = str_replace($keywords, $replace_with, $email_template['subject']);
            $html = str_replace($keywords, $replace_with, $email_template['body']);
            //MAIL TEMLATE CLOSE
            //
            sendMail($to, $subject, '', $html);
            $success_array = array('error' => 'success', 'msg' => 'RSVP Successfully!');
        }
        return $success_array;
    }

    function common_feedback($target_id, $rating, $feedback_type) {
        $add_feedback = $this->common_user_model->saveFeedback($target_id, $rating, $feedback_type);
    }

    function common_question($attendee_id, $session_id, $question) {
        $add_question = $this->common_user_model->add_session_quetion($attendee_id, $session_id, $question);
    }

    function common_save_share($user_data, $data) {
        //display($data);
        $data['subject_id'] = $data['target_attendee_id'];
        $data['subject_type'] = $data['target_user_type'];
        $data['attendee_id'] = $user_data->attendee_id;
        $data['attendee_type'] = $user_data->attendee_type;
        //display($data);

        $organizer_data = $this->common_user_model->getOrganizer(NULL, $data['event_id']);
        $get_target_attendee = $this->common_user_model->getUserData($data['subject_id']);

        $save_social = $this->common_user_model->saveSocial($data);
        $to = $get_target_attendee->email;
        //MAIL TEMLATE
        $email_template = get_email_template('saved share profile');
        $keywords = array('{app_name}', '{event_name}', '{first_name}', '{save_shared}', '{subject_first_name}', '{object_first_name}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}');
        $replace_with = array(
            $email_template['setting']['app_name'],
            $organizer_data->event_name,
            $user_data->first_name,
            $save_social,
            $get_target_attendee->first_name,
            $user_data->first_name,
            $email_template['setting']['app_contact_email'],
            SITE_URL,
            CLIENT_IMAGES
        );
        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
        $html = str_replace($keywords, $replace_with, $email_template['body']);

        //MAIL TEMLATE CLOSE

        if (check_DND($data['subject_id']))
            sendMail($to, $subject, '', $html);
        //update the rigtside notificatin flag
        update_rightside_notification();
        //show_query();
    }

    function push_ad_analytics($user_data, $data) {
        $object_id = $user_data->attendee_id;
        $object_type = $user_data->attendee_type;
        $ad_type = $data['ad_type'];
        $ad_id = $data['ad_id'];
        $event_id = $data['event_id'];

        $ad_analytics = $this->common_user_model->push_ad_analytics($object_id, $object_type, $ad_type, $ad_id, $event_id);
    }

}

?>
