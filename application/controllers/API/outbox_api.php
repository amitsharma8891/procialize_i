<?php

class outbox_api extends CI_Controller {

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
        $this->load->model('API/client_event_api_model', 'model');
        $this->load->model('API/client_login_api_model', 'login_model');
        $this->load->model('API/client_notification_api_model', 'notification_model');
        $this->load->model('common_model/common_transaction_model');
        $this->load->model('common_user_model');
        $this->load->model('mobile_model');
        $this->load->helper('emailer_helper');
    }

    function outbox_sync() {

        $outbox_data = mysql_real_escape_string($this->input->post('outbox_data'));
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something went wrong';
        if ($outbox_data) {
            $table_array = array(
                'inbox_data' => $outbox_data,
                'created_date' => date('Y-m-d H:i:s')
            );

            $this->db->insert('inbox', $table_array);

            if ($this->db->insert_id()) {
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Success';
            }
        }

        json_output($json_array);
    }

    function app_outbox_sync() {
        //echo 'sfasdf';
        $query = $this->db->get('inbox');
        $result = $query->result_array();
        //display($result);
        if ($result) {
            foreach ($result as $value) {
                //echo '--->' . $value['id'];
                $json_data = stripslashes($value['inbox_data']);
                $json_data = json_decode(stripslashes($json_data), true);
                //display($json_data);
                $process_data = $this->process_data($json_data);
                $this->db->where('id',$value['id']);
                $this->db->delete('inbox');
            }
        }
    }

    function process_data($post_data) {
       // echo 'sfasfs';
        //display($post_data);
        //exit;
        if ($post_data['outbox']) {
            foreach ($post_data['outbox'] as $key => $value) {
                if ($value['type'] == 'analytic') {
                    //display($value);
                    $api_access_token = $value['data']['api_access_token'];
                    $analytic_type = $value['data']['analytic_type'];
                    $target_id = $value['data']['target_id'];
                    $target_type = $value['data']['target_type'];
                    $event_id = $value['data']['event_id'];
                    $push_analytics = $this->push_analytics($api_access_token,$analytic_type,$target_id,$target_type,$event_id);
                }

                if ($value['type'] == 'send_message') {
                    $send_message = $this->send_message($value['data']);
                }
                if ($value['type'] == 'set_meeting') {
                    $send_message = $this->set_meeting($value);
                }

                if ($value['type'] == 'rsvp') {
                    //display($value);
                    //echo '1213';
                    $do_rsvp = $this->session_rsvp($value['data']);
                }
                if ($value['type'] == 'question') {
                    $add_question = $this->add_session_quetion($value['data']);
                }
                if ($value['type'] == 'feedback') {
                    $add_feedback = $this->add_feedback($value['data']);
                }
                if ($value['type'] == 'save_share_profile') {
                    $save_social = $this->save_share_social($value['data']); 
                }
                if ($value['type'] == 'save_profile') {
                    
                    $value['data']['target_attendee_id'] = $value['data']['subject_id'];
                    $value['data']['target_user_type'] = $value['data']['subject_type'];
                    //display($value);
                    $save_social = $this->save_share_social($value['data']);
                }
                if($value['type'] == 'ad')
                {
                    display($value);
                    $push_ad_analytics = $this->push_ad_analytics($value['data']);
                }
            }
        }
    }

    function send_message($data) {
       // echo 'send';
        //display($data);
        $api_access_token                                                       = $data['api_access_token'];//$this->input->post('api_access_token');
        $user_data                                                              = check_access_token($api_access_token,$check_null = TRUE);
        $event_id                                                               = $data['event_id'];//$this->input->post('event_id');
        $attendee_id                                                            = $user_data->attendee_id;
        $attendee_type                                                          = $user_data->attendee_type;
        $message                                                                = $data['message_text'];//mysql_real_escape_string($this->input->post('message_text',TRUE));
        $checkbox                                                               = @$data['message_checkbox'];//$this->input->post('message_checkbox');
        $target_attendee_id                                                     = $data['target_attendee_id'];//$this->input->post('target_attendee_id');
        $target_user_type                                                       = $data['target_user_type'];//$this->input->post('target_user_type');
        $mulitple_attendee_id                                                   = $data['multiple_attendee'];//$this->input->post('mulitple_attendee');
        
        
        if ($checkbox) {
            //echo '127 broadcast';
            $message_id = $this->model->getMessageCounter($attendee_id, $target_attendee_id);
            $this->common_transaction_model->broadcast_msg = TRUE;
            //$send_msg                                                       = $this->model->send_mesage($attendee_id,md5($message_id->message_count),0,$target_user_type,$message,$event_id);
            $this->common_transaction_model->message = $message;
            $this->common_transaction_model->event_id = $event_id;
            $send_msg = $this->common_transaction_model->common_send_message($type = 'send', $user_data, $event_id, $target_attendee_id, $target_user_type);
        } else {
            if (array_filter((array)$mulitple_attendee_id, 'strlen')) {
                //echo '136 multiple';
                $this->common_transaction_model->broadcast_msg = FALSE;
                $this->model->multiple_msg = TRUE;
                foreach ($mulitple_attendee_id as $k => $v) {
                  //  echo '139 multiple'.$v.$this->getAttendeeType($v);
                    $this->common_transaction_model->message = $message;
                    $this->common_transaction_model->event_id = $event_id;
                    $send_msg = $this->common_transaction_model->common_send_message($type = 'send', $user_data, $event_id, $v, $this->getAttendeeType($v));
                }
            } else {
                //echo '145 single';
                $this->common_transaction_model->message = $message;
                $this->common_transaction_model->event_id = $event_id;
                $send_msg = $this->common_transaction_model->common_send_message($type = 'send', $user_data, $event_id, $target_attendee_id, $target_user_type);
            }
        }
    }

        function set_meeting($data) {
            //display($data);
        }

        function session_rsvp($data) {
            $api_access_token = $data['api_access_token']; //$this->input->post('api_access_token');
            $user_data = check_access_token($api_access_token, $check_null = TRUE);
            $event_id = $data['event_id']; //$this->input->post('event_id');
            $attendee_id = $user_data->attendee_id;
            $session_id = $data['session_id']; //$this->input->post('session_id');
            $json_array['error'] = 'error';
            $json_array['msg'] = 'Something Went Wrong';
            if ($session_id && is_numeric($session_id)) {
                $check_rsvp = $this->common_user_model->check_rsvp($session_id, $user_data->attendee_id);
                if (!$check_rsvp) {
                    $do_rsvp = $this->common_transaction_model->common_do_rsvp($user_data, $event_id, $session_id);
                }
            }
            //echo '170';
            //show_query();
        }

        function add_feedback($data) {
            //display($data);
            $target_id = $data['target_id'];
            $rating = $data['rating'];
            $feedback_type = $data['feedback_type'];
            $event_id = $data['event_id'];
            $save_feedback = $this->common_transaction_model->common_feedback($target_id, $rating, $feedback_type);
            //echo '180';
            //show_query();
        }

        function add_session_quetion($data) {
            //display($data);
            $api_access_token = $data['api_access_token'];
            $user_data = check_access_token($api_access_token, $check_null = TRUE);
            $question = $data['question'];
            $session_id = $data['session_id'];
            $attendee_id = $user_data->attendee_id;
            $save_question = $this->common_transaction_model->common_question($attendee_id, $session_id, $question);
            //echo '192';
            //show_query();
        }

        function push_analytics($api_access_token, $analytic_type, $target_id, $target_type, $event_id) {
            $api_access_token;
            $user_data = check_access_token($api_access_token, $check_null = TRUE);
            //show_query();
            $attndee_id = $user_data->attendee_id;
            $attndee_type = $user_data->attendee_type;
            $json_array['error'] = 'error';
            $json_array['msg'] = 'Something Went Wrong';
            if ($analytic_type && $target_id && $target_type && $event_id) {
                $this->model->push_analytics($analytic_type, $attndee_id, $attndee_type, $target_id, $target_type, $event_id);
                $json_array['error'] = 'success';
                $json_array['msg'] = 'analytics data pushed successfully';
            }
            //echo '210';
            //show_query();
            //json_output($json_array);
        }
        
        function push_ad_analytics($data)
        {
            //display($data);
            $api_access_token = $data['api_access_token']; 
            $user_data = check_access_token($api_access_token, $check_null = TRUE);
            $this->common_transaction_model->push_ad_analytics($user_data,$data);
        }
        
        function save_share_social($data)
        {
            $api_access_token = $data['api_access_token']; 
            $user_data = check_access_token($api_access_token, $check_null = TRUE);
            /*$event_id = $data['event_id']; 
            $attendee_id  = $user_data->attendee_id;
            $attendee_type = $user_data->attendee_type;
            $type = $data['type'];
            $transaction_type = $data['transaction_type'];
            $target_attendee_id = $data['target_attendee_id'];
            $target_user_type = $data['target_user_type'];*/
            $sav_social = $this->common_transaction_model->common_save_share($user_data,$data);
            
            
            //display($data);
        }
        
        function getAttendeeType($attendee_id)
        {
            if($attendee_id)
            {
                $query =  $this->db
                        -> select('attendee_type')
                        -> from('attendee')
                        -> where('id',$attendee_id)
                        -> get()->row();
                return @$query->attendee_type;
            }
        }

    }
    