<?php

class event_cron_job extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('API/client_event_api_model', 'model');
        $this->load->model('API/client_login_api_model', 'login_model');
        $this->load->model('API/client_notification_api_model', 'notification_model');
        $this->load->helper('emailer_helper');
        $this->load->model('common_user_model');
        date_default_timezone_set("Asia/Kolkata");
    }

    function cron_list() {
        echo 'hello world';
    }

    function before_15_min_notification() {
        $table_aaray = array(
            'value' => 'temp 22',
            'datetime' => date('Y-m-d H:i:s')
        );
        $this->db->insert('temp_table', $table_aaray);

        $current = date('Y-m-d H:i'); //echo '<br>';
        $session_result = $this->get_current_date_session();
        //display($session_result);
        if (!$session_result)
            return FALSE;
        //show_query();
        //display($session_result);


        foreach ($session_result as $session) {
            $before_15 = date('Y-m-d H:i', strtotime($session['start_time'] . ' -15 minutes'));
            if ($before_15 == $current) {
                $organizer_data = $this->common_user_model->getOrganizer(NULL, $session['event_id']);
                //display($organizer_data);
                //echo 'before 15';
                $session_id = $session['session_id'];
                $attendee_list = $this->get_session_attendee($session_id);
                //display($attendee_list);
                if ($attendee_list) {
                    $email_template = get_email_template('before_15_min_email_to_attendee');
                    $keywords = array('{app_name}', '{event_name}', '{subject_first_name}', '{session_name}', '{session_time}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}');

                    foreach ($attendee_list as $attendee) {
                        //$subject = $organizer_data->event_name . ' - Networking App by Procialize - ' . $user_data->first_name . ' has sent a message ';
//                        $html = str_replace('{event_name}', $organizer_data->event_name, before_15_min_email_to_attendee());
//                        $html = str_replace('{subject_first_name}', $attendee['first_name'], $html);
//                        $html = str_replace('{session_name}', $session['session_name'], $html);
//                        $html = str_replace('{session_time}', date('H:i', strtotime($session['start_time'])), $html);
//                        $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);

                        $to = $attendee['email'];
                        $replace_with = array(
                            $email_template['setting']['app_name'],
                            $organizer_data->event_name,
                            $attendee['first_name'],
                            $session['session_name'],
                            date('H:i', strtotime($session['start_time'])),
                            SITE_URL,
                            CLIENT_IMAGES,
                            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">'
                        );
                        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                        $html = str_replace($keywords, $replace_with, $email_template['body']);
//                        $subject = 'Session Reminder';
                        //if(check_DND($attendee['attendee_id']))
                        sendMail($to, $subject, '', $html);
                    }
                }
            }
        }
    }

    function before_10_min_notification() {
        $session_result = $this->get_current_date_session();
        if (!$session_result)
            return;
        $current = date('Y-m-d H:i');
        foreach ($session_result as $session) {
            $organizer_data = $this->common_user_model->getOrganizer(NULL, $session['event_id']);
            $before_10 = date('Y-m-d H:i', strtotime($session['end_time'] . ' -10 minutes'));
            if ($before_10 == $current) {
                $session_id = $session['session_id'];
                $attendee_list = $this->get_session_attendee($session_id);
                if ($attendee_list) {
                    //MAIL TEMLATE***
                    $email_template = get_email_template('before_10_min_email_to_attendee');
                    $keywords = array('{app_name}', '{event_name}', '{subject_first_name}', '{session_name}', '{session_time}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}');

                    //MAIL TEMLATE CLOSE***
                    foreach ($attendee_list as $attendee) {
//                        $html = str_replace('{event_name}', $organizer_data->event_name, before_10_min_email_to_attendee());
//                        $html = str_replace('{subject_first_name}', $attendee['first_name'], $html);
//                        $html = str_replace('{session_name}', $session['session_name'], $html);
//                        $html = str_replace('{session_time}', date('H:i', strtotime($session['start_time'])), $html);
//                        $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);
                        $to = $attendee['email'];
                        $replace_with = array(
                            $email_template['setting']['app_name'],
                            $organizer_data->event_name,
                            $attendee['first_name'],
                            $session['session_name'],
                            date('H:i', strtotime($session['start_time'])),
                            SITE_URL,
                            CLIENT_IMAGES,
                            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">'
                        );
                        $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                        $html = str_replace($keywords, $replace_with, $email_template['body']);
                        if (check_DND($attendee['attendee_id']))
                            sendMail($to, $subject, '', $html);
                    }
                }
            }
        }
    }

    function get_current_date_session() {
        $get_event_query = $this->db
                ->select('S_T.id as session_id,S_T.name as session_name,S_T.start_time,S_T.end_time,S_T.event_id,S_T.track_id,E_T.name as event_name ')
                ->from('session as S_T')
                ->join('event as E_T', 'S_T.event_id = E_T.id')
                ->where('DATE(S_T.start_time)', date('Y-m-d'))
                ->get();
        $session_result = $get_event_query->result_array();
        return $session_result;
    }

    function get_session_attendee($session_id) {
        $query = $this->db
                ->select('S_A.attendee_id,A_T.name,U_T.id as user_id,U_T.email,U_T.first_name')
                ->from('session_has_attendee as S_A')
                ->join('attendee as A_T', 'A_T.id = S_A.attendee_id')
                ->join('user as U_T', 'U_T.id = A_T.user_id')
                ->where('S_A.session_id', $session_id)
                ->get();
        $result = $query->result_array();
        return $result;
    }

}
