<?php

class User_notification extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Event controller
     * @author		Amit  sharma
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        //$this->session->set_userdata( array('event_reffaral' => $_SERVER['REQUEST_URI']));
        $this->load->model('client/client_notification_model', 'model');
        $this->load->model('client/client_event_model');
        $this->load->model('client/client_login_model');
        $this->load->helper('emailer_helper');
    }

    function notification_view() {
        $data = array();
        $event_id = $this->client_event_model->event_id = $this->session->userdata('client_event_id');
        $data = $this->client_event_model->getCount();


        $event_id = $this->session->userdata('client_event_id');
        $attendee_id = $this->model->subject_id = $this->session->userdata('client_attendee_id');
        //update notification
        $update_data = $this->model->update_notification_status($attendee_id);



        $data['notification'] = $this->notificaton_data();
//        /display($data);exit;
        $this->load->view(CLIENT_NOTIFICATION_VIEW, $data);
    }

    function notificaton_data() {
        $data = array();
        $notification_id = $this->uri->segment(4);
        $notification = $this->model->getNotification($notification_id);
        return $notification;
    }

    function notification_detail() {
        $data = array();
        $event_id = $this->client_event_model->event_id = $this->session->userdata('client_event_id');
        $data = $this->client_event_model->getCount();
        $notification_type_array = array('A', 'E', 'O', 'Mtg', 'Msg', 'F', 'N');
        $notification_type = $this->uri->segment(3);
        $notification_id = $this->uri->segment(4);
        $attendee_id = $this->session->userdata('client_attendee_id');

        if (in_array($notification_type, $notification_type_array) && $notification_id) {
            $this->model->notification_type = $notification_type;
            $data['notification_id'] = $notification_id;
            $data['notification_view_type'] = $notification_type;
            $data['notification_detail'] = $this->model->getNotification($notification_id);

            //display($data);exit;
            $this->load->view(CLIENT_NOTIFICATION_DETAIL_VIEW, $data);
        }
    }

    function social_message() {
        $event_id = $this->session->userdata('client_event_id');
        $attendee_id = $this->session->userdata('client_attendee_id');

        //$data
    }

    function saveToggle() {
        $data['subject_id'] = $this->input->post('subject_id');
        $data['subject_type'] = $this->input->post('subject_type');
        $data['toggle_flag'] = $this->input->post('toggle_flag');
        $data['type'] = $this->input->post('type');
        $data['attendee_id'] = $this->session->userdata('client_attendee_id');
        $data['attendee_type'] = $this->session->userdata('client_user_type');
        $data['event_id'] = $this->session->userdata('client_event_id');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong!';
        $get_organizer = $this->client_event_model->getOrganizer($data['event_id']);
        if (is_numeric($data['subject_id']) && $data['toggle_flag'] && $data['attendee_id'] && $data['type']) {


            $save_social = $this->model->saveSocial($data);
            $json_array['error'] = 'success';
            $json_array['msg'] = $save_social . ' Successfully!';

            $get_target_attendee = $this->client_login_model->getUserData($data['subject_id']);
            $company_and_designation = "";
            $cmpny_designation = $user_data->designation;
            if (!empty($cmpny_designation)) {
                if (isset($user_data->company_name) && !empty($user_data->company_name)) {
                    $company_and_designation = '(' . $user_data->designation . ',' . $user_data->company_name . ')'; //$this->session->userdata('client_user_designation');
                } else {
                    $company_and_designation = '(' . $user_data->designation . ')'; //$this->session->userdata('client_user_designation');
                }
            }
            //MAIL TEMLATE START
            $email_template = get_email_template('saved_share_profile');
            $keywords = array('{app_name}', '{event_name}', '{first_name}', '{subject_first_name}', '{save_shared}', '{object_first_name}', '{user_designation_company_name}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
            $replace_with = array(
                $email_template['setting']['app_name'],
                $get_organizer->event_name,
                $user_data->first_name,
                $get_target_attendee->first_name,
                $save_social,
                $user_data->first_name,
                $company_and_designation,
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
//            $subject = $get_organizer->event_name . ' - Networking App by Procialize - ' . $this->session->userdata('client_first_name') . ' has ' . $save_social . ' your profile';
//            $html = str_replace('{event_name}', $get_organizer->event_name, saved_share_profile_temp());
//            $html = str_replace('{subject_first_name}', $get_target_attendee->first_name, $html);
//            $html = str_replace('{save_shared}', $save_social, $html);
//            $html = str_replace('{object_first_name}', $this->session->userdata('client_first_name') . ',' . $this->session->userdata('client_user_company'), $html);
//            $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);

            $to = $get_target_attendee->email;
            if (check_DND($data['subject_id']))
                sendMail($to, $subject, '', $html);
            //if($toggle_flag)
            //update the rigtside notificatin flag
            update_rightside_notification();
        }
        echo json_encode($json_array);
    }

    function feedback() {
        $feedback_type_array = array('session', 'event_feedback');
        $target_id = $this->input->post('target_id', TRUE);
        $rating = $this->input->post('rating', TRUE);
        $feedback_type = $this->input->post('feedback_type', TRUE);
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong!';
        if (is_numeric($rating) && in_array($feedback_type, $feedback_type_array) && is_numeric($target_id)) {
            $save_feedback = $this->model->saveFeedback($target_id, $rating, $feedback_type);
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Feedback Registered Successfully';
        }

        echo json_encode($json_array);
    }

    function share_via_email() {
        $data['to'] = mysql_real_escape_string($this->input->post('to'));
        $data['body'] = mysql_real_escape_string($this->input->post('body'));
        $data['subject'] = mysql_real_escape_string($this->input->post('subject'));
        $data['subject_id'] = $this->input->post('subject_id');
        $data['subject_type'] = $this->input->post('subject_type');
        $data['type'] = 'Sh';
        $data['toggle_flag'] = 'insert';
        $data['attendee_id'] = $this->session->userdata('client_attendee_id');
        $data['attendee_type'] = $this->session->userdata('client_user_type');
        $data['event_id'] = $this->session->userdata('client_event_id');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong!';


        if (is_numeric($data['subject_id']) && $data['toggle_flag'] && $data['attendee_id'] && $data['type']) {
            $save_social = $this->model->saveSocial($data);
            $json_array['error'] = 'success';
            $json_array['msg'] = $save_social;
            //if($toggle_flag)

            if ($data['to']) {
                $to_array = explode(',', $data['to']);
                if ($to_array) {
                    //
                    //MAIL TEMLATE START
                    $email_template = get_email_template('share_by_email');
                    $keywords = array('{app_name}', '{mail_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');

                    //MAIL TEMLATE CLOSE
                    foreach ($to_array as $k => $v) {
                        $replace_with = array(
                            $email_template['setting']['app_name'],
                            str_replace('\n', '<br>', $data['body']),
                            $email_template['setting']['app_contact_email'],
                            SITE_URL,
                            CLIENT_IMAGES,
                            '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                        );
                        //str_replace($keywords, $replace_with, $email_template['subject']);
                        $html = str_replace($keywords, $replace_with, $email_template['body']);

//                        $html = str_replace('{mail_content}', str_replace('\n', '<br>', $data['body']), share_procialize_via_email());
//                        $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);
                        header('content-type: text/html; charset=UTF-8');
                        //if(check_DND($v))
                        sendMail($v, $data['subject'], '', $html, $this->session->userdata('client_email'), $this->session->userdata('client_user_name'));
                    }
                }
            }
            update_rightside_notification();
        }
        echo json_encode($json_array);
    }

    function update_social_notification() {
        $attendee_id = $this->session->userdata('client_attendee_id');
        $event_id = $this->session->userdata('client_event_id');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something went wrong';
        if (!$attendee_id && !$event_id)
            return;
        $this->db->where('attendee_id', $attendee_id);
        $this->db->where('event_id', $event_id);
        $this->db->update('event_has_attendee', array('rightside_social_notification' => 1));
        $json_array['error'] = 'success';
        echo json_encode($json_array);
    }

    function share_procialize() {
        $data['to'] = mysql_real_escape_string($this->input->post('to'));
        $data['body'] = mysql_real_escape_string($this->input->post('body'));
        $data['subject'] = mysql_real_escape_string($this->input->post('subject'));
        $data['attendee_id'] = $this->session->userdata('client_attendee_id');
        $data['attendee_type'] = $this->session->userdata('client_user_type');
        $data['event_id'] = $this->session->userdata('client_event_id');
        $json_array['error'] = 'error'; 
        $json_array['msg'] = 'Something Went Wrong!';
        if (is_numeric($data['attendee_id']) && $data['to']) {
            $save_social = $this->model->shareProcialize($data);
            $json_array['error'] = 'success';
            $json_array['msg'] = $save_social;
            update_rightside_notification();
        }
        if ($data['to']) {
            $to_array = explode(',', $data['to']);
            if ($to_array) {
                $email_template = get_email_template('share_by_email');
                $keywords = array('{app_name}', '{mail_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');

                foreach ($to_array as $k => $v) {

                    $replace_with = array(
                        $email_template['setting']['app_name'],
                        str_replace('\n', '<br>', $data['body']),
                        $email_template['setting']['app_contact_email'],
                        SITE_URL,
                        CLIENT_IMAGES,
                        '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                    );
                    //str_replace($keywords, $replace_with, $email_template['subject']);
                    $html = str_replace($keywords, $replace_with, $email_template['body']);


//                    $html = str_replace('{mail_content}', str_replace('\n', '<br>', $data['body']), share_procialize_via_email());
//                    $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);
                    header('content-type: text/html; charset=UTF-8');
                    //if(check_DND())
                    sendMail($v, $data['subject'], '', $html);
                }
            }
        }

        $first_name = 'Somebody';
        $to = ADMIN_EMAIL_ADDRESS;

        if ($this->session->userdata('client_first_name'))
            $first_name = $this->session->userdata('client_first_name');
        $subject = $first_name . ' shared Procialize App';
        $html = str_replace('{first_name}', $first_name, share_procialize());
        $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);


        header('content-type: text/html; charset=UTF-8');
        //sendMail($to, $subject, '',$html);
        echo json_encode($json_array);
    }

    function push_ad_analytics() {
        $object_id = $this->input->post('object_id');
        $object_type = $this->input->post('object_type');
        $ad_type = $this->input->post('ad_type');
        $ad_id = $this->input->post('ad_id');
        $event_id = $this->input->post('event_id');

        if ($object_id && $object_type && $ad_type && $ad_id) {
            $this->model->push_ad_analytics($object_id, $object_type, $ad_type, $ad_id, $event_id);
        }
    }

    function web_push_notification() {
        $attendee_id = $this->session->userdata('client_attendee_id');
        $event_id = $this->session->userdata('client_event_id');
        $json_array['social_notify'] = FALSE;
        $message_notification = $this->model->notificationCount($attendee_id);
        $social_notification = $this->model->socialNotificationCount($attendee_id, $event_id);
        $json_array['message_count'] = $message_notification;
        if ($social_notification)
            $json_array['social_notify'] = TRUE;

        echo json_encode($json_array);
    }

}
