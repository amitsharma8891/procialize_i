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
        $company_and_designation = "";
        $cmpny_designation = $user_data->designation;
        if (!empty($cmpny_designation)) {
            if (isset($user_data->company_name) && !empty($user_data->company_name)) {
                $company_and_designation = '(' . $user_data->designation . ',' . $user_data->company_name . ')'; //$this->session->userdata('client_user_designation');
            } else {
                $company_and_designation = '(' . $user_data->designation . ')'; //$this->session->userdata('client_user_designation');
            }
        }
        $email_template = get_email_template('send_message_email_info');
        $keywords = array('{app_name}', '{event_name}', '{subject_first_name}', '{first_name}', '{object_first_name}', '{user_designation_company_name}', '{msg_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
        $replace_with = array(
            $email_template['setting']['app_name'],
            $organizer_data->event_name,
            $get_target_attendee->first_name,
            $user_data->first_name,
            $user_data->first_name,
            $company_and_designation,
            $this->message,
            $email_template['setting']['app_contact_email'],
            SITE_URL,
            CLIENT_IMAGES,
            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '"/>',
            '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>',
            '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
        );
        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
        $html = str_replace($keywords, $replace_with, $email_template['body']);
        $to = $get_target_attendee->email;
        if ($this->message_id)
            $message_id = $this->message_id;
        else
        {
            $message_id = $this->getMessageCounter($user_data->attendee_id, $subject_id);
            //show_query();
            //echo $message_id->message_count;
            //$message_id = md5($message_id->message_count);
        }
            

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
                //->where_not_in('message_id', 0)
                ->where('type', 'Msg')
                ->where("((subject_id = $attendee_id AND object_id = $target_attendee_id) OR (subject_id = $target_attendee_id  AND object_id = $attendee_id))")
                ->get();
        $query_result = $check_message_query->row();
        //show_query();
        if ($query_result)
            return $query_result->message_count;



        $query = $this->db
                ->select('message_count')
                ->from('message_counter')
                ->get();
        $result = $query->row();
        $this->db->update('message_counter', array('message_count' => $result->message_count + 1));
        //display($result);

        return md5($result->message_count);
    }

    
    
    function common_set_meeting($type, $user_data, $event_id, $subject_id, $subject_type) {
        $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        $get_target_attendee = $this->common_user_model->getUserData($subject_id);
        $check_slot = $this->check_slot($subject_id, $event_id, $this->meeting_start_time, $this->meeting_end_time);
        if ($check_slot && $type == 'set')
            return array('check_slot' => $check_slot, 'set_meeting' => '', 'reply_meeting' => '');
        if ($type == 'set') {
            $reply_meeting = '';
            $email_template = get_email_template('mail_for_setup_meeting');
            $set_meeting = $this->set_meeting($user_data->attendee_id, $user_data->attendee_type, $subject_id, $subject_type, $event_id, $this->message, $this->meeting_start_time, $this->meeting_end_time);
        } else {
            $set_meeting = '';
            $email_template = get_email_template('reply_mail_for_meeting_setup');
            $reply_meeting = $this->reply_meeting($user_data->attendee_id, $user_data->attendee_type, $subject_id, $subject_type, $event_id, $this->message, $this->meeting_id);
        }
        $to = $get_target_attendee->email;
        //MAIL TEMLATE
        $company_and_designation = "";
        $cmpny_designation = $user_data->designation;
        if (!empty($cmpny_designation)) {
            if (isset($user_data->company_name) && !empty($user_data->company_name)) {
                $company_and_designation = '(' . $user_data->designation . ',' . $user_data->company_name . ')'; //$this->session->userdata('client_user_designation');
            } else {
                $company_and_designation = '(' . $user_data->designation . ')'; //$this->session->userdata('client_user_designation');
            }
        }
        $keywords = array('{app_name}', '{event_name}', '{meeting_date}', '{meeting_time}', '{subject_first_name}', '{object_first_name}', '{user_designation_company_name}', '{msg_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
        $replace_with = array(
            $email_template['setting']['app_name'],
            $organizer_data->event_name,
            date('d M Y', strtotime($this->meeting_start_time)),
            date('h .i A', strtotime($this->meeting_end_time)),
            $get_target_attendee->first_name,
            $user_data->first_name,
            $company_and_designation,
            $this->message,
            $email_template['setting']['app_contact_email'],
            SITE_URL,
            CLIENT_IMAGES,
            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">',
            '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>',
            '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
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
        $attendee_id = $user_data->attendee_id;
        $check_event_register = $this->common_user_model->check_passcode($event_id, $attendee_id);
        if (!$check_event_register) {
            $json_array['error'] = 'error';
            $json_array['msg'] = 'Please first register to the Event';

            return $json_array;
        }

        $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        $get_session = $this->common_user_model->getSession($session_id);

        $check_rsvp = $this->common_user_model->check_rsvp($session_id, $user_data->attendee_id);
        $success_array = array('error' => 'success', 'msg' => 'Already RSVPed to the session');
        if (!$check_rsvp) {
            $rsvp = $this->common_user_model->do_rsvp($session_id, $user_data->attendee_id);
            $to = $organizer_data->email;
            //MAIL TEMLATE
            $email_template = get_email_template('mail_to_organizer_when_attendee_rsvp');
            $keywords = array('{app_name}', '{session_name}', '{org_name}', '{object_first_name}', '{event_name}', '{first_name}', '{email}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
            $replace_with = array(
                $email_template['setting']['app_name'],
                @$get_session[0]['session_name'],
                $organizer_data->organizer_name,
                $user_data->first_name,
                $organizer_data->event_name,
                $user_data->first_name,
                $user_data->email,
                $email_template['setting']['app_contact_email'],
                SITE_URL,
                CLIENT_IMAGES,
                '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
            );
            $subject = str_replace($keywords, $replace_with, $email_template['subject']);
            $html = str_replace($keywords, $replace_with, $email_template['body']);
            //MAIL TEMLATE CLOSE
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
        //MAIL TEMLATE START
        $email_template = get_email_template('saved_share_profile');
        $keywords = array('{app_name}', '{event_name}', '{first_name}', '{save_shared}', '{subject_first_name}', '{object_first_name}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
        $replace_with = array(
            $email_template['setting']['app_name'],
            $organizer_data->event_name,
            $user_data->first_name,
            $save_social,
            $get_target_attendee->first_name,
            $user_data->first_name,
            $email_template['setting']['app_contact_email'],
            SITE_URL,
            CLIENT_IMAGES,
            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
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

    function common_event_registration($user_data, $event_id) {
        $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        $attendee_id = $user_data->attendee_id;
        $error = 'error';
        $msg = 'Something Went Wrong!';
        $check_attendee = $this->common_user_model->checkAttendee($event_id, $attendee_id);
        if ($check_attendee) {
            $error = 'success';
            $msg = 'You have already registered for this event, check your mail regularly. You will receive the event Passcode from Procialize Admin team.';
        } else {
            $save_attendee = $this->common_user_model->insert_attendee($event_id, $attendee_id);
            //mail template start****
            $to = $organizer_data->email;
            $email_template = get_email_template('mail_to_organizer_for_registration_request');
            $keywords = array('{app_name}', '{event_name}', '{org_name}', '{first_name}', '{email}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
            $replace_with = array(
                $email_template['setting']['app_name'],
                $organizer_data->event_name,
                $organizer_data->organizer_name,
                $this->session->userdata('client_first_name'),
                $this->session->userdata('client_email'),
                $email_template['setting']['app_contact_email'],
                SITE_URL,
                CLIENT_IMAGES,
                '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
            );
            $subject = str_replace($keywords, $replace_with, $email_template['subject']);
            $html = str_replace($keywords, $replace_with, $email_template['body']);
            sendMail($to, $subject, '', $html);
            //mail template end***
            $error = 'success';
            $msg = 'Thank you. Your registration request has been sent to the organizer. You shall receive a mail along with Passcode from Procialize Admin soon.';
        }

        return array('error' => $error, 'msg' => $msg);
    }

    function common_notification_passcode_validation($event_id, $attendee_id) {
        $this->db->select('status,passcode');
        $this->db->where('attendee_id', $attendee_id);
        $this->db->where('event_id', $event_id);
        $result = $this->db->get('event_has_attendee')->row();
        if (isset($result->status) && !empty($result->status) && $result->status) {
            return true;
        } else {
            if ($result->status == 0) {
                $this->db->where('attendee_id', $attendee_id);
                $this->db->where('event_id', $event_id);
                $this->db->update('event_has_attendee', array('status' => 1));
                return true;
            } else {
                return false;
            }
        }
    }

// email template sybncronization  start
    function get_template_html($user_data, $event_id = '', $subject_id = '', $session_array = array(), $meeting_array = array()) {
        $keyword = ''; //$this->common_user_model->get_keyword();
        $organizer_data = array();
        $get_target_attendee = array();
        $get_session = array();
        if ($event_id)
            $organizer_data = $this->common_user_model->getOrganizer(NULL, $event_id);
        if ($subject_id)
            $get_target_attendee = $this->common_user_model->getUserData($subject_id);
    }

    function common_set_email_template_data($email_temp_name, $dynamic_variable_value) {
        $email_template = get_email_template($email_temp_name);
        $keywords = array(
            '{first_name}', //1
            '{subject_first_name}', //2
            '{object_first_name}', //3
            '{email}', //4
            '{session_name}', //5
            '{session_time}', //6
            '{mail_content}', //7
            '{username}', //8
            '{password_link}', //9
            '{org_name}', //10    
            '{meeting_date}', //11
            '{meeting_time}', //12
            '{duration}', //13
            '{password}', //14    
            '{address}', //15
            '{message_content}', //16    
            '{msg_content}', //17    
            '{save_shared}', //18    
            '{event_name}', //19
            '{app_name}', //20    
            '{app_contact_email}', //21    
            '{site_url}', //22
            '{IMAGE_PATH}', //23    
            '{logo_image}', //24    
            '{apple_app_store}', //25    
            '{google_play_store}'   //26    
        );
        $fix_constant_variable_value_array = array(
            $email_template['setting']['app_name'], //20
            $email_template['setting']['app_contact_email'], //21
            SITE_URL, //22
            CLIENT_IMAGES, //23
            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '"/>', //24
            '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', //25
            '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'//26
        );
        $replace_with = array_merge($dynamic_variable_value, $fix_constant_variable_value_array);
        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
        $html = str_replace($keywords, $replace_with, $email_template['body']);
        sendMail($to, $subject, '', $html);
    }

// email template sybncronization  End
}

?>
