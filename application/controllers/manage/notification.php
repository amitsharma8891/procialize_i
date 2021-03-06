<?php

class Notification extends CI_Controller {

    public $event_id;

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Aatish Gore
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('notification_model', 'model');

        $this->load->model('exhibitor_model');
        $this->load->model('event_feedback_model');
        $this->load->model('organizer_model');
        $this->load->model('user_model');
        $this->load->model('attendee_model');
        $this->load->model('speaker_model');
        $this->load->helper('admin_emailer');
        $this->load->model('push_notification/mobile_push_notification_model', 'mobile_model');
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    /**
     * index
     *
     * This displays  content
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    public function index($order = 0) {
        
    }

    public function getAll($json = 'no', $read = 'yes') {
        $type = $this->session->userdata('type_of_user');
        $id = $this->session->userdata('id');
        $arrRead = array();
        if ($read == 'no') {
            $arrRead[] = 0;
            $arrRead[] = 1;
        } else {
            $arrRead[] = 0;
            $arrRead[] = 1;
        }

        if ($json == 'json')
            $this->model->limit = 5;
        $this->model->notification_type = array('A', 'N', 'F', 'S');
        $notification = $this->model->getNotification($type, $id, $arrRead);

        $arrNotification = array();
        $i = 0;


        $update_id = array();
        $unread = 0;
        foreach ($notification as $notify) {
            if ($notify['read'] == 0)
                $unread++;
            if ($notify['object_type'] == 'O') {
                $user_info = array();
                $user_info = $this->organizer_model->get($notify['object_id']);

                $arrNotification[$i]['name'] = $user_info[0]['name'];
                $arrNotification[$i]['content'] = $notify['content'];
                $arrNotification[$i]['type'] = $notify['type'];
                $arrNotification[$i]['event_name'] = $notify['event_name'];

                $arrNotification[$i]['display_time'] = time_elapsed_string($notify['display_time']);
                $arrNotification[$i]['user'] = 'Organizer';

                ;
            }

            if ($notify['object_type'] == 'E') {
                $user_info = array();
                $user_info = $this->exhibitor_model->get($notify['object_id']);
                $arrNotification[$i]['name'] = $user_info[0]['name'];
                $arrNotification[$i]['content'] = $notify['content'];
                $arrNotification[$i]['type'] = $notify['type'];
                $arrNotification[$i]['event_name'] = $notify['event_name'];
                $arrNotification[$i]['display_time'] = time_elapsed_string($notify['display_time']);
                $arrNotification[$i]['user'] = 'Exhibitor';

                ;
            }

            $i++;
            $update_id[] = $notify['id'];
        }
        if ($read == 'yes') {
            $data['read'] = 1;
            if (count($update_id) > 0)
                $this->model->update($update_id, $data);
            $arrData['unread'] = 0;
        }else {
            $arrData['unread'] = count($arrNotification);
        }
        $arrData['unread'] = $unread;
        $arrData['notifications'] = $arrNotification;

        header('Content-Type: application/json');
        $json = json_encode($arrData);
        echo str_replace("\\", "", $json);

        exit;
    }

    /**
     * add
     *
     * add content
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    function add() {
        //echo '<pre>';print_r($this->input->post());  //exit;
        //echo "<br>";
        $mobile_notification = '';
        $arrInsert['content'] = $this->input->post('content');
        if ($this->input->post('type') == 'F') {
            $arrInsertFeedBack['event_id'] = $this->event_id;
            $arrInsertFeedBack['star'] = 0;
            $arrInsertFeedBack['total'] = 0;
            $feedback_id = $this->event_feedback_model->save($arrInsertFeedBack);
            $arrInsert['content'] = '<a href="' . base_url() . FEEDBACK_CONTENT . $feedback_id . '">' . $this->input->post('content') . '</a>';
            $arrInsert['feedback_id'] = $feedback_id;
        }
        $arrInsert['status'] = 1;
        $arrInsert['created_by'] = getCreatedUserId();
        $arrInsert['created_date'] = $this->input->post('notification_date');
        $arrInsert['type'] = $this->input->post('type');
        $arrInsert['event_id'] = $this->event_id;

        if ($this->input->post('now')) {
            $arrInsert['display_time'] = date("Y-m-d H:i:s");
        } else {
            list($date, $string) = explode(' ', $this->input->post('notification_date'));
            $arrInsert['display_time'] = $date . " " . $this->input->post('notification_time');
        }

        if ($this->session->userdata('type_of_user') == 'E') {
            $exhibitor = $this->exhibitor_model->getAll($this->session->userdata('id'), true);

            $arrInsert['object_id'] = $exhibitor->attendee_id;
        } else {
            $arrInsert['object_id'] = $this->session->userdata('id');
        }

        $arrInsert['object_type'] = $this->session->userdata('type_of_user');
        // print_r($arrInsert);
        $arrSave = array();
        if ($this->input->post('exhibitor') && $this->input->post('type') != 'F') {
            $arrData = array();
            $search = $this->event_id;
            $field = array("exhibitor.event_id");
            $arrData = $this->exhibitor_model->getAll(NULL, FALSE, $search, $field, 'exhibitor.id', 'AND');
            //echo "<br>";
            //echo $this->db->last_query();
            //echo "<br>";
            //print_r($arrData);
            //echo "<br>";exit;
            foreach ($arrData as $ele) {
                $arrInsert['created_date'] = $ele['created_date'];
                $arrInsert['event_id'] = $ele['event_id'];
                $arrInsert['subject_id'] = $ele['attendee_id'];
                $arrInsert['subject_type'] = 'E';
                $arrSave[] = $arrInsert;
            }
        }

        if ($this->input->post('attendee')) {
            $arrData = array();
            $search = $this->event_id;
            $field = array("event_has_attendee.event_id");
            $this->attendee_model->attendee_type = array('A', 'E', 'S');
            $arrData = $this->attendee_model->getAll(NULL, FALSE, $search, $field, 'AND');
            //display($arrData);exit;
//            show_query();
//            display($arrData); 
//            exit;
//            echo $this->db->last_query();
            foreach ($arrData as $ele) {
                $arrInsert['created_date'] = $ele['created_date'];
                $arrInsert['event_id'] = $ele['event_id'];
                $arrInsert['subject_id'] = $ele['attendee_id'];
                $arrInsert['subject_type'] = 'A';
                $arrSave[] = $arrInsert;
                $to = $ele['email'];
                $gcm_reg_id = $ele['gcm_reg_id'];
                $mobile_os = $ele['mobile_os'];
                if ($this->input->post('type') == 'F') {
                    $mobile_notification = 'Organizer has sent you a Feedback Request';
//                    $subject = '{event_name} - Networking App by {app_name} - Feedback Request from Organizer';
//                    $email_html = feedback_requested_by_organizer();
                    $email_template = get_email_template('feedback_requested_by_organizer');
                } elseif ($this->input->post('type') == 'A') {
                    $mobile_notification = 'Organizer has sent you an Alert';
//                    $subject = '{event_name} - Networking App by {app_name} - Alert from Organizer';
//                    $email_html = alert_from_organizer();
                    $email_template = get_email_template('alert_from_organizer');
                } elseif ($this->input->post('type') == 'N') {
                    $mobile_notification = 'Organizer has sent you a Notification';
//                    $subject =  '{event_name} - Networking App by {app_name} - Notification from Organizer';
//                    $email_html = notification_from_organizer();
                    $email_template = get_email_template('notification_from_organizer');
                }
                //MAIL TEMLATE
                $keywords = array('{app_name}', '{event_name}', '{first_name}', '{message_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
                $replace_with = array(
                    $email_template['setting']['app_name'],
                    $ele['event_name'],
                    $ele['first_name'],
                    $this->input->post('content'),
                    $email_template['setting']['app_contact_email'],
                    SITE_URL,
                    CLIENT_IMAGES,
                    '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                );
                $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                $html = str_replace($keywords, $replace_with, $email_template['body']);

                //MAIL TEMLATE CLOSE
                if ($gcm_reg_id) {
                    $responce = $this->mobile_model->send_notification($gcm_reg_id, $mobile_os, $mobile_notification);
                }
//                if (check_DND($element['attendee_id'])) {
//                    echo 'mail sending';
//                    sendMail($to, $subject, '', $html);
//                }


                if (check_DND($ele['attendee_id'])) {
                    $message['to'] = $to;
                    $message['subject'] = $subject;
                    $message['html'] = $html;
                    $result = $this->db->insert('mail_notification_tbl', $message);
                }
            }
        } elseif ($this->input->post('attendee_id')) {
            foreach ($this->input->post('attendee_id') as $attendee_id) {
                //echo $attendee_id;
                $arrData = $this->attendee_model->getAll($attendee_id, FALSE, $search = NULL, $field = NULL, 'AND');
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrInsert['event_id'] = $this->event_id;
                $arrInsert['subject_id'] = $attendee_id;
                $arrInsert['subject_type'] = 'A';
                $arrSave[] = $arrInsert;
                $to = $arrData[0]['email'];
                $gcm_reg_id = $arrData[0]['gcm_reg_id'];
                $mobile_os = $arrData[0]['mobile_os'];
                if ($this->input->post('type') == 'F') {
                    $mobile_notification = 'Organizer has sent you a Feedback Request';
//                    $subject = $arrData[0]['event_name'] . ' - Networking App by Procialize - Feedback Request from Organizer';
                    $email_template = get_email_template('feedback_requested_by_organizer');
                } elseif ($this->input->post('type') == 'A') {
                    $mobile_notification = 'Organizer has sent you an Alert';
//                    $subject = $arrData[0]['event_name'] . ' - Networking App by Procialize - Alert from Organizer';
                    $email_template = get_email_template('alert_from_organizer');
                } elseif ($this->input->post('type') == 'N') {
                    $mobile_notification = 'Organizer has sent you a Notification';
//                    $subject = $arrData[0]['event_name'] . ' - Networking App by Procialize - Notification from Organizer';
                    $email_template = get_email_template('notification_from_organizer');
                }

                //MAIL TEMLATE
                $keywords = array('{app_name}', '{event_name}', '{first_name}', '{message_content}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
                $replace_with = array(
                    $email_template['setting']['app_name'],
                    $arrData[0]['event_name'],
                    $arrData[0]['first_name'],
                    $this->input->post('content'),
                    $email_template['setting']['app_contact_email'],
                    SITE_URL,
                    CLIENT_IMAGES,
                    '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                );
                $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                $html = str_replace($keywords, $replace_with, $email_template['body']);

                //MAIL TEMLATE CLOSE
                if ($gcm_reg_id) {
                    $responce = $this->mobile_model->send_notification($gcm_reg_id, $mobile_os, $mobile_notification);
                }
                if (check_DND($arrData[0]['attendee_id'])) {
                    $message['to'] = $to;
                    $message['subject'] = $subject;
                    $message['html'] = $html;
                    $result = $this->db->insert('mail_notification_tbl', $message);
                }
            }
        }

        $status = false;

        if (!empty($arrSave)) {
            $status = $this->model->save($arrSave);
            //display($arrData);exit;
        }

        if ($status) {
            $this->session->set_flashdata('message', 'Notification Added Successfully !!');
            redirect('manage/index');
        } else {
            $this->session->set_flashdata('message', 'Failed to Add Notification!!');
            redirect('manage/index/');
        }
    }

}

/* End of file top_level.php */
/* Location: ./application/controllers/admin/top_level.php */