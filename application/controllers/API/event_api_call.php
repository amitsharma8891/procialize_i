<?php

class Event_api_call extends CI_Controller {

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
        $this->load->model('push_notification/mobile_push_notification_model', 'mobile_model');
        $this->load->model('common_model/common_transaction_model');
        $this->load->model('common_user_model');
        $this->load->helper('emailer_helper');
    }

    function event_list() {
        $user_id = $this->session->userdata('client_user_id');
        $attendee_id = $this->session->userdata('client_attendee_id');
        $accsee_token = $this->uri->segment(4); //'a2557a7b2e94197ff767970b67041697';
        $search = NULL;
        $this->model->attendee_id = '';
        if ($accsee_token) {
            $user_data = check_access_token($accsee_token, $check_null = TRUE);
            $this->model->common_city = $user_data->city;
            $this->model->common_industry = $user_data->attendee_industry;
            $this->model->attendee_id = $user_data->attendee_id; //$attendee_id;
            //display($user_data);
        }
        $this->model->access_token = $accsee_token; //$attendee_id;
        $data = $this->model->getAll(NULL, NULL, $search);
        return $data;
//        json_output($data);
    }

    function get_data($event_id, $single_row, $search) {
        $data = $this->model->getAll($event_id, $single_row, $search);
        return $data;
    }

    function search() {
        if (!isset($_GET['term']))
            exit;

        $this->model->search = mysql_real_escape_string(urldecode($this->input->get('term', TRUE)));
        $options = array();
        $json_array = array();
        $this->model->autocomplete = TRUE;
        $data = $this->model->getAll(); //$this->get_data(NULL,NUll,$search);   
        $data['term'] = $this->input->get('term', TRUE);
        //$data['query']                                                          = show_query();
        //show_query();

        /* if($data['event_list'])
          {
          foreach($data['event_list'] as $key => $value)
          {
          $json_array[]                                                   = array(
          'label'             => strip_slashes($value['event_name']),
          'id'                => $value['event_id'],
          'title'             => $value['event_name'],
          'image'             => $value['event_logo'],
          'value'             => $value['event_name'],
          );
          }
          } */

        json_output($data);
    }

    function event_login() {
        $api_access_token = mysql_real_escape_string($this->input->post('api_access_token'));
        $passcode = mysql_real_escape_string($this->input->post('passcode'));
        $event_id = mysql_real_escape_string($this->input->post('event_id'));
        ;
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid inputs!';
        if ($api_access_token && $passcode && $event_id) {
            $check_passcode = $this->model->check_passcode($event_id, $api_access_token, $passcode);
            $user_data = $this->model->getUser($api_access_token);
            if ($check_passcode && $user_data) {
                $this->db->where('attendee_id', $user_data->attendee_id);
                $this->db->where('event_id', $event_id);
                $this->db->update('event_has_attendee', array('status' => 1));
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Success';
            }
        }

        echo json_encode($json_array);
    }

    function notification_passcode_validation() {
        $api_access_token = mysql_real_escape_string($this->input->post('api_access_token'));
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $passcode = mysql_real_escape_string($this->input->post('passcode'));
        $event_id = $this->input->post('event_id');
        $attendee_id = $user_data->attendee_id;
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Passcode!';
        if ($user_data && $passcode && $event_id) {
            $passcode_validation = $this->common_transaction_model->common_notification_passcode_validation($event_id, $attendee_id, $passcode);
            $json_array['error'] = $passcode_validation['error'];
            $json_array['msg'] = $passcode_validation['msg'];
        }
        json_output($json_array);
    }

    function get_unread_messages() {
        $api_access_token = $this->uri->segment('4');
        $user_data = check_access_token($api_access_token, $check_null = FALSE);
        $attendee_id = $user_data->attendee_id;
        $notification = $this->notification_model->notificationCount($attendee_id);
        json_output($notification);
    }

    function notification_list() {
        $api_access_token = $this->uri->segment('4');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $attendee_id = $this->notification_model->subject_id = $user_data->attendee_id;

        $update_data = $this->notification_model->update_notification_status($attendee_id);
        $data = $this->notification_model->getNotification();
        json_output($data);
    }

    function wall_notification_list() {
//        $api_access_token = $this->uri->segment('4');
//        $user_data = check_access_token($api_access_token, $check_null = TRUE);
//        $attendee_id = $this->notification_model->subject_id = $user_data->attendee_id;
//        $update_data = $this->notification_model->get_notification_list($attendee_id);
        $data = $this->notification_model->getwallNotification();
        echo json_encode($data);
    }

    function update_notification_count() {
        $api_access_token = $this->uri->segment('4');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $attendee_id = $user_data->attendee_id;
        $json_array['error'] = 'success';
        $json_array['msg'] = 'count updated successfully.';
        $update_data = $this->notification_model->update_notification_status($attendee_id);
        //show_query();
        json_output($json_array);
    }

    function notification_detail() {
        $api_access_token = $this->uri->segment('4');
        $user_data = check_access_token($api_access_token, $check_null = FALSE);
        $attendee_id = $user_data->attendee_id;
    }

    function get_social_msg() {
        //$api_access_token                                                       = $this->uri->segment('4');
        //$event_id                                                               = $this->uri->segment('5');
        //$user_data                                                              = check_access_token($api_access_token,$check_null = FALSE);
        //$attendee_id                                                            = $user_data->attendee_id;
        $data = array();
        $data['error'] = 'error';
        $data['msg'] = 'somthing went wrong';
        $event_list = $this->model->get_all_event_list();
        if ($event_list) {
            $data['error'] = 'success';
            $data['msg'] = 'success';

            foreach ($event_list as $key => $value) {
                //$data['message_list'][$value['event_id']]                                           = $this->notification_model->getSocialMessage(NULL, $value['event_id']);
                $data['message_list'][]['event_id'] = $value['event_id'];
                //$data['message_list'][]['event_id']                               = $value['event_id'];
                $data['message_list'][$key]['messages'] = $this->notification_model->getSocialMessage(NULL, $value['event_id']);
            }
        }


        json_output((array) $data);
    }

    function check_event_access() {
        $api_access_token = $this->input->post('api_access_token');
        $event_id = $this->input->post('event_id');
        $user_data = check_access_token($api_access_token, $check_null = FALSE);
        $attendee_id = $user_data->attendee_id;
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Not Registered to event';

        $get_event_user = $this->model->check_event_access($event_id, $attendee_id);
        if ($get_event_user) {
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Registered to event';
        }
        json_output($json_array);
    }

    function get_industry() {
        $data['industry_list'] = $this->model->getIndustry();
        json_output($data);
    }

    function get_functionality() {
        $data['functionality_list'] = $this->model->getFunctionality();
        json_output($data);
    }

    function get_messages() {
        $event_id = $this->uri->segment(5);
        $api_access_token = $this->uri->segment(4);
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        //display($user_data);

        $attendee_id = $this->notification_model->subject_id = $user_data->attendee_id;
        $data['notification'] = $this->notification_model->getNotification();
        json_output($data);
    }

    function get_message_details() {

        $notification_type = $this->uri->segment(4);
        $notification_id = $this->uri->segment(5);
        $event_id = $this->model->event_id = $this->uri->segment(6);
        $api_access_token = $this->uri->segment(7);
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $notification_type_array = array('A', 'E', 'O', 'Mtg', 'Msg', 'F', 'N');
        $attendee_id = $user_data->attendee_id;
        $data['error'] = 'error';
        $data['msg'] = 'Something went wrong';
        if (in_array($notification_type, $notification_type_array) && $notification_id) {
            $this->notification_model->notification_type = $notification_type;
            $data['notification_id'] = $notification_id;
            $data['notification_view_type'] = $notification_type;
            $data['notification_detail'] = $this->notification_model->getNotification($notification_id);
            $data['error'] = 'success';
            $data['msg'] = 'success';
        }

        json_output($data);
    }

    function get_saved_profile() {
        $user_type = $this->uri->segment(4);
        $event_id = $this->uri->segment(5);
        $api_access_token = $this->uri->segment(6);
        $event_id = $this->input->post('event_id');
        $user_data = check_access_token($api_access_token, $check_null = FALSE);
        $attendee_id = $user_data->attendee_id;
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something went wrong';

        $user_type_array = array('attendee', 'exhibitor', 'speaker');

        $attendee_type = '';
        if (in_array($user_type, $user_type_array)) {
            if ($user_type == 'attendee')
                $attendee_type = 'A';
            elseif ($user_type == 'exhibitor')
                $attendee_type = 'E';
            elseif ($user_type == 'speaker')
                $attendee_type = 'S';
            $this->notification_model->attendee_type = $attendee_type;
            $data['page_type'] = $user_type;

            $json_array['saved_profile'] = $this->notification_model->getSocialMessage($attendee_id, $event_id);
            $json_array['error'] = 'success';
            $json_array['msg'] = 'data found';
        }

        json_output($json_array);
    }

    function get_twitter() {
        //$event_id                                                               = $this->uri->segment(4); 
        $twiter['twiter_list'] = array();
        $tweets = array();
        $get_all_event = $this->model->getAllEvent();
        $tweet_array = array();
        foreach ($get_all_event as $key => $value) {
            $twiter_hashtag = DEFAULT_TWITTER_HASHTAG;
            if ($value) {
                $twiter_hashtag = $this->model->getHashTag($value['event_id']);
            }
            include_once APPPATH . 'libraries/tweeter_oauth/twitteroauth.php';

            $oauth_access_token = "2517362072-9fZgBTq25VOqQolVK2yGwwmZH4gy40kDyWIOrJj";
            $oauth_access_token_secret = "oLZD0UYuK1FJ3QNFwZZ6mqiSIPmgFLqLdVadQQrQjOT5e";
            $consumer_key = "CGdeB0gRrKhD3THZkZf7gNbad";
            $consumer_secret = "RX6LcQfmyoYyzQjX23IAs7LZ2lXoYegJNcnRh5waBpHcvmcPIm";

            $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);
            $tweets = $twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $twiter_hashtag . '&count=10');
            //display($tweets);
            if (isset($tweets->errors)) {
                $tweet_array['tweets_list'][$key]['event_id'] = $value['event_id'];
                $tweet_array['tweets_list'][$key]['tweets'] = array();
                //$tweet_array[$value['event_id']]['event_id']                    = $value['event_id'];
            } else {
                $tweet_array['tweets_list'][$key]['event_id'] = $value['event_id'];
                $tweet_array['tweets_list'][$key]['tweets'] = (array) $tweets;
                //$tweet_array[$value['event_id']]['event_id']                    = $value['event_id'];
            }
        }
        json_output($tweet_array);
    }

    function default_twitter() {
        $tweets = $this->twitter(getSetting()->app_twitter_hash_tag);
        if (isset($tweets->errors))
            $tweet_array['tweets_list']['tweets'] = array();
        else
            $tweet_array['tweets_list']['tweets'] = (array) $tweets;
        json_output($tweet_array);
    }

    function twitter($twiter_hashtag) {
        if (!$twiter_hashtag)
            return FALSE;

        include_once APPPATH . 'libraries/tweeter_oauth/twitteroauth.php';
        $oauth_access_token = "2517362072-9fZgBTq25VOqQolVK2yGwwmZH4gy40kDyWIOrJj";
        $oauth_access_token_secret = "oLZD0UYuK1FJ3QNFwZZ6mqiSIPmgFLqLdVadQQrQjOT5e";
        $consumer_key = "CGdeB0gRrKhD3THZkZf7gNbad";
        $consumer_secret = "RX6LcQfmyoYyzQjX23IAs7LZ2lXoYegJNcnRh5waBpHcvmcPIm";

        $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);
        $tweets = $twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $twiter_hashtag . '&count=10');
        return $tweets;
    }

    function get_user_details() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $data['user_data'] = $this->login_model->getUserData($user_data->attendee_id);

        json_output($data['user_data']);
    }

    function send_message() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        //display($user_data);
        $event_id = $this->input->post('event_id');
        $attendee_id = $user_data->attendee_id;
        $attendee_type = $user_data->attendee_type;
        $message = mysql_real_escape_string($this->input->post('message_text', TRUE));
        $checkbox = $this->input->post('message_checkbox');
        $target_attendee_id = $this->input->post('target_attendee_id');
        $target_user_type = $this->input->post('target_user_type');
        $mulitple_attendee_id = $this->input->post('multiple_attendee'); //multiple_attendee
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        $get_organizer = $this->model->getOrganizer(NULL, $event_id);
        //display($get_organizer);
        //display($this->input->post());

        if ($event_id && $attendee_id && $message && $get_organizer) {
            if ($checkbox) {
                $message_id = $this->model->getMessageCounter($attendee_id, $target_attendee_id);
                $this->common_transaction_model->broadcast_msg = TRUE;
                //$send_msg                                                       = $this->model->send_mesage($attendee_id,md5($message_id->message_count),0,$target_user_type,$message,$event_id);
                $this->common_transaction_model->message = $message;
                $this->common_transaction_model->event_id = $event_id;
                $send_msg = $this->common_transaction_model->common_send_message($type = 'send', $user_data, $event_id, $target_attendee_id, $target_user_type);
            } else {
                if (array_filter((array) $mulitple_attendee_id, 'strlen')) {
                    $this->model->multiple_msg = TRUE;
                    foreach ((array) $mulitple_attendee_id as $k => $v) {
                        //echo '385';
                        $this->common_transaction_model->message = $message;
                        $this->common_transaction_model->event_id = $event_id;
                        $send_msg = $this->common_transaction_model->common_send_message($type = 'send', $user_data, $event_id, $v, $this->getAttendeeType($v));
                        //display($send_msg);
                    }
                } else {
                    //echo '393';
                    $this->common_transaction_model->message = $message;
                    $this->common_transaction_model->event_id = $event_id;
                    $send_msg = $this->common_transaction_model->common_send_message($type = 'send', $user_data, $event_id, $target_attendee_id, $target_user_type);
                    //display($send_msg);
                }
            }
            if ($send_msg) {
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Message has been sent successfully!';

                //$this->db->update('message_counter',array('message_count' => $message_id->message_count+1));
            }
        }

        json_output($json_array);
    }

    function reply_message() {

        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $attendee_id = $user_data->attendee_id;
        $attendee_type = $user_data->attendee_type;
        $message = mysql_real_escape_string($this->input->post('message_text', TRUE));
        $target_attendee_id = $this->input->post('target_attendee_id');
        $target_user_type = $this->input->post('target_attendee_type');
        $message_id = $this->input->post('message_id');
        $event_id = $this->input->post('event_id');
        if ($attendee_id && $message && $target_attendee_id && $message_id) {
            //$get_target_attendee                                        		= $this->login_model->getUserData($target_attendee_id);
            //$send_msg                                                           = $this->model->send_mesage($attendee_id,$attendee_type,$message_id,$target_attendee_id,$target_attendee_type,$message,$event_id);
            $this->common_transaction_model->message = $message;
            $this->common_transaction_model->event_id = $event_id;
            $send_msg = $this->common_transaction_model->common_send_message($type = 'reply', $user_data, $event_id, $target_attendee_id, $target_user_type);
            if ($send_msg) {
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Message Sent Successfully!';
            }

            /* if($get_target_attendee->gcm_reg_id)
              {

              $mobile_message = $user_data->first_name.' '.bracket_attendee_attribute($user_data->designation,$user_data->company_name,'-').' sent you a message';
              $responce = $this->mobile_model->send_notification($get_target_attendee->gcm_reg_id,$get_target_attendee->mobile_os,$mobile_message);
              //echo $responce;
              } */
        }

        json_output($json_array);
    }

    function share_profile() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        // display($user_data);
        $data['event_id'] = $this->input->post('event_id');
        $data['attendee_id'] = $user_data->attendee_id;
        $data['attendee_type'] = $user_data->attendee_type;
        $data['subject_id'] = $this->input->post('target_attendee_id');
        $data['subject_type'] = $this->input->post('target_user_type');
        $data['type'] = $this->input->post('type');
        $data['transaction_type'] = $this->input->post('transaction_type');
        $data['to'] = mysql_real_escape_string(@$this->input->post('to'));
        $data['body'] = mysql_real_escape_string(@$this->input->post('body'));
        $data['subject'] = mysql_real_escape_string(@$this->input->post('subject'));
        $get_organizer = $this->model->getOrganizer(NULL, $data['event_id']);
        if (is_numeric($data['subject_id']) && $data['transaction_type'] && $data['attendee_id'] && $data['type']) {
            if ($data['to']) {
                $to_array = explode(',', $data['to']);
                if ($to_array) {
                    foreach ($to_array as $k => $v) {
                        sendMail($v, $data['subject'], '', $data['body']);
                    }
                }
                $save_social = 'Shared';
            } else {
                $save_social = $this->notification_model->saveSocial($data);
                $get_target_attendee = $this->login_model->getUserData($data['subject_id']);
                //$subject                                                            = 'Procialize:  '.$get_target_attendee->first_name.' '.$save_social.' your profile';
//				$subject                                                            = $get_organizer->event_name.' - Networking App by Procialize - '.$user_data->first_name.' has '.$save_social.' your profile';
//                $html                                                               = str_replace('{event_name}', $get_organizer->event_name,saved_share_profile_temp());
//                $html                                                               = str_replace('{subject_first_name}', $get_target_attendee->first_name ,$html);
//                $html                                                               = str_replace('{save_shared}',$save_social  ,$html);
//                $html                                                               = str_replace('{object_first_name}',  $user_data->first_name ,$html);
//                $html                                                               = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);
                $company_and_designation = "";
                $cmpny_designation = $user_data->designation;
                if (!empty($cmpny_designation)) {
                    if (isset($user_data->company_name) && !empty($user_data->company_name)) {
                        $company_and_designation = '(' . $user_data->designation . ',' . $user_data->company_name . ')'; //$this->session->userdata('client_user_designation');
                    } else {
                        $company_and_designation = '(' . $user_data->designation . ')'; //$this->session->userdata('client_user_designation');
                    }
                }
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

                $to = $get_target_attendee->email;
                if (check_DND($data['subject_id']))
                    sendMail($to, $subject, '', $html);
                //update the rigtside notificatin flag
                update_rightside_notification();
            }
            $json_array['error'] = 'success';
            $json_array['msg'] = $save_social . ' successfully.';
        }

        json_output($json_array);
    }

    function session_rsvp() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $event_id = $this->input->post('event_id');
        $attendee_id = $user_data->attendee_id;
        $session_id = $this->input->post('session_id');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';

        if ($session_id && is_numeric($session_id)) {
            $rsvp = $this->common_transaction_model->common_do_rsvp($user_data, $event_id, $session_id);
            $json_array['error'] = $rsvp['error'];
            $json_array['msg'] = $rsvp['msg'];
        }
        json_output($json_array);
    }

    function get_set_meeting_data() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $data['from_id'] = $user_data->attendee_id;
        $data['to_id'] = $this->input->post('target_id');
        $event_id = $this->input->post('event_id');
        $data['to_name'] = $this->model->getName($data['to_id']);
        $to_array = array();
        $from_array = array();




        $data['agenda_list'] = array();


        $agenda_list = $this->model->getRsvpSession($data['from_id'], $data['to_id'], $event_id);
        $meeting_list = $this->model->getMeeting($data['from_id'], $data['to_id'], $event_id);
        //display($data['meeting_list']);
        $data['agenda_list'] = array_merge($agenda_list, $meeting_list);
        foreach ($data['agenda_list'] as $key => $value) {
            if ($data['from_id'] == $value['object_id'] || $data['from_id'] == @$value['subject_id']) {
                $from_array[$key] = $value;
                $from_array[$key]['track_id'] = 0;
            }

            if ($data['to_id'] == $value['object_id'] || $data['to_id'] == @$value['subject_id']) {
                $to_array[$key] = $value;
                $to_array[$key]['track_id'] = 1;
            }
        }

        $data['agenda_list'] = (array) array_merge($from_array, $to_array);
        $data['event_date_list'] = $this->model->getEventDate($event_id);
        $data['event_date_list'] = createDateRangeArray(date('Y-m-d', strtotime($data['event_date_list']->event_start)), date('Y-m-d', strtotime($data['event_date_list']->event_end)));


        json_output($data);
    }

    ###################################################################TRANSACTIONS#######################################################################

    function login() {
        $email = mysql_real_escape_string($this->input->post('email', TRUE));
        $password = mysql_real_escape_string($this->input->post('password', TRUE));
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Credentials!';
        $json_array['api_access_token'] = '';
        if ($email && $password) {
            $this->login_model->password = $password;
            $user_data = $this->login_model->check_user(NULL, $email, $row = 'row');
            if ($user_data) {
                //display($user_data);
                if ($user_data->status == 1) {
                    if ($user_data->api_access_token) {
                        $json_array['api_access_token'] = $user_data->api_access_token;
                    } else {
                        //create api_access_token
                        $api_access_token = md5($user_data->attendee_id);
                        $this->db->where('id', $user_data->attendee_id);
                        $this->db->update('attendee', array('api_access_token' => $api_access_token, 'modified_date' => date('Y-m-d H:i:s')));
                        $json_array['api_access_token'] = $api_access_token;
                    }
                    $event_list = $this->event_list();
                    $json_array = $event_list;
                    $wall_notification_list = $this->notification_model->getwallNotification();
                    $json_array['wall_notification'] = $wall_notification_list;
                    $json_array['user_data'] = $user_data;
                    $json_array['user_event_list'] = $this->model->get_user_event_list($user_data->attendee_id);
                    $json_array['user_saved_attendee'] = $this->model->get_saved_profile_id($user_data->attendee_id, 'A');
                    $json_array['user_saved_exhibitor'] = $this->model->get_saved_profile_id($user_data->attendee_id, 'E');
                    $json_array['user_saved_speaker'] = $this->model->get_saved_profile_id($user_data->attendee_id, 'S');
                    $json_array['error'] = 'success';
                    $json_array['msg'] = 'Valid User!';
                } else {
                    $json_array['msg'] = 'This user has been blocked!';
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($json_array);
        exit;
    }

    function get_user_info() {
        $api_access_token = $this->input->post('api_access_token');
        $check_access = check_access_token($api_access_token, $check_null = TRUE);
        $user_data = $this->login_model->getUserData($check_access->attendee_id);
        $json_array['user_data'] = $user_data;
        $json_array['user_event_list'] = $this->model->get_user_event_list($check_access->attendee_id);
        $json_array['user_saved_attendee'] = $this->model->get_saved_profile_id($check_access->attendee_id, 'A');
        $json_array['user_saved_exhibitor'] = $this->model->get_saved_profile_id($check_access->attendee_id, 'E');
        $json_array['user_saved_speaker'] = $this->model->get_saved_profile_id($check_access->attendee_id, 'S');
        $json_array['error'] = 'success';
        $json_array['msg'] = 'Success';
        json_output($json_array);
    }

    function user_register() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $api_access_token = $this->input->post('api_access_token');


        if ($api_access_token) {
            $user_data = check_access_token($api_access_token, $check_null = TRUE);
            if (!$user_data) {
                $json_array['error'] = 'error';
                $json_array['msg'] = 'Something Went Worng!';
                header('Content-Type: application/json');
                echo json_encode($json_array);
                exit;
            }
        }


        if (!$api_access_token) {
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[conf_password]');
            $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
        $this->form_validation->set_rules('company', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('industry_id[]', 'Industry', 'trim|required');
        $this->form_validation->set_rules('functionality_id[]', 'Functionality', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|callback_mobileno_check');

        if ($this->form_validation->run() == FALSE) {
            $json_array['error'] = 'error';
            $json_array['email_err'] = form_error('email');
            $json_array['password_err'] = form_error('password');
            $json_array['conf_password_err'] = form_error('conf_password');
            $json_array['first_name_err'] = form_error('first_name');
            $json_array['last_name_err'] = form_error('last_name');
            $json_array['designation_err'] = form_error('designation');
            $json_array['company_err'] = form_error('company');
            $json_array['industry_id_err'] = form_error('industry_id[]');
            $json_array['functionality_id_err'] = form_error('functionality_id[]');
            $json_array['city_err'] = form_error('city');
            $json_array['mobile_err'] = form_error('mobile');
        } else {

            $data = $this->input->post(NULL, TRUE);
            $data['social_type'] = 'normal';
            $this->login_model->insert_type = 'normal';
            $data['location'] = '';
            $data['linkdin'] = '';
            $data['linkedin_id'] = '';
            $data['public_profile_url'] = '';
            //$data['description']                                                = '';

            $user_id = @$user_data->user_id;
            $this->login_model->attendee_id = @$user_data->attendee_id;
            $save_user = $this->login_model->save_user($user_id, $data); //returns api access token
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Saved Successfully';

            if (!$api_access_token) {
                $api_access_token = md5($save_user['attendee_id']);
                $this->db->where('id', $save_user['attendee_id']);
                $this->db->update('attendee', array('api_access_token' => md5($save_user['attendee_id'])));
            }
            $json_array['api_access_token'] = $api_access_token;


            $get_user_data = $this->model->getUser($api_access_token);
            $user_data = $this->login_model->getUserData(@$get_user_data->attendee_id);
            $json_array['user_data'] = $user_data;
            $json_array['user_event_list'] = $this->model->get_user_event_list(@$user_data->attendee_id);
            $json_array['user_saved_attendee'] = $this->model->get_saved_profile_id(@$user_data->attendee_id, 'A');
            $json_array['user_saved_exhibitor'] = $this->model->get_saved_profile_id(@$user_data->attendee_id, 'E');
            $json_array['user_saved_speaker'] = $this->model->get_saved_profile_id(@$user_data->attendee_id, 'S');
        }
        header('Content-Type: application/json');
        echo json_encode($json_array);
    }

    function event_registration() {
        $api_access_token = $this->input->post('api_access_token');
        $event_id = $this->input->post('event_id');
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        if (is_numeric($event_id) && $user_data) {
            $event_registration = $this->common_transaction_model->common_event_registration($user_data, $event_id);
            $json_array['error'] = $event_registration['error'];
            $json_array['msg'] = $event_registration['msg'];
        }
        json_output($json_array);
    }

    function verify_change_password() {
        $this->load->model('client/client_event_model');
        $email = $this->input->post('email');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Email Address!';
        if ($email) {
            $check_user = $this->client_event_model->getUser($email);
            if ($check_user) {
                $user_data = $check_user[0];
                //display($check_user);
                $password_key = md5($user_data['user_id']);

                $this->db->where('id', $user_data['user_id']);
                $this->db->update('user', array('password_key' => $password_key));

                $to = $email;
                $subject = 'Change password for your Procialize App';
                $password_link = '<a href="' . SITE_URL . 'user/change-password/' . $password_key . '">Click</a>';

                $html = str_replace('{first_name}', $user_data['first_name'], forget_password_temp());
                $html = str_replace('{password_link}', $password_link, $html);
                $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);

                header('content-type: text/html; charset=UTF-8');
                sendMail($to, $subject, '', $html);
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Password Reset Link has been sent to your email adderess';
            }
        }
        json_output($json_array);
    }

    function saved_attendee() {
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Not Saved attendee';
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $attendee_id = $user_data->attendee_id;
        $attendee_type = $user_data->attendee_type;
        $subject_id = $this->input->post('target_attendee_id');
        $subject_type = $this->input->post('target_attendee_type');

        $check_saved = $this->notification_model->checkSavedShared($subject_id, $attendee_id, 'Sav');
        //display($check_saved);
        if ($check_saved) {
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Saved attendee';
        }

        json_output($json_array);
    }

    function save_social() {
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);

        $data['attendee_id'] = $user_data->attendee_id;
        $data['attendee_type'] = $user_data->attendee_type;
        $data['subject_id'] = $this->input->post('subject_id');
        $data['subject_type'] = $this->input->post('subject_type');
        $data['event_id'] = $this->input->post('event_id');
        $data['type'] = $this->input->post('type');
        $data['transaction_type'] = $this->input->post('transaction_type');

        $social = $this->notification_model->saveSocial($data);
        //show_query();
        if ($social) {
            $json_array['error'] = 'success';
            $json_array['msg'] = $social;
        }
        json_output($json_array);
    }

    function add_session_quetion() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        $question = mysql_real_escape_string($this->input->post('question', TRUE));
        $session_id = mysql_real_escape_string($this->input->post('session_id', TRUE));


        $attendee_id = $user_data->attendee_id;
        if ($question && $session_id && $attendee_id) {
            $table_array = array(
                'session_id' => $session_id,
                'attendee_id' => $attendee_id,
                'question' => $question,
                'created_date' => date('Y-m-d H:i:s'),
                'pvt_org_id' => 1,
            );
            $this->db->insert('session_question', $table_array);

            if ($this->db->insert_id()) {
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Question added successfully and will be answered by Speakers at the time of session';
            }
        }

        json_output($json_array);
    }

    function feedback() {
        $feedback_type_array = array('session', 'event_feedback');
        $target_id = $this->input->post('target_id', TRUE);
        $rating = $this->input->post('rating', TRUE);
        $feedback_type = $this->input->post('feedback_type', TRUE);
        $event_id = $this->input->post('event_id', TRUE);
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong!';
        if (is_numeric($rating) && in_array($feedback_type, $feedback_type_array) && is_numeric($target_id)) {
            $save_feedback = $this->model->saveFeedback($target_id, $rating, $feedback_type);
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Feedback Registered Successfully';
        }

        json_output($json_array);
    }

    function set_meeting() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $data['start_time'] = date('Y-m-d H:i:s', strtotime($this->input->post('start')));
        $data['end_time'] = date('Y-m-d H:i:s', strtotime($this->input->post('end')));
        $data['target_id'] = $this->input->post('target_id');
        $data['target_type'] = $this->input->post('target_type');
        $data['title'] = $this->input->post('title');
        $data['attendee_id'] = $user_data->attendee_id;
        $data['attendee_type'] = $user_data->attendee_type;
        $data['event_id'] = $this->input->post('event_id');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something went Wrong!';
        $get_organizer = $this->model->getOrganizer(NULL, $data['event_id']);
        if ($data['start_time'] && $data['end_time'] && $data['target_id'] && $data['title'] && is_numeric($data['event_id'])) {
            $this->common_transaction_model->message = $data['title'];
            $this->common_transaction_model->meeting_start_time = $data['start_time'];
            $this->common_transaction_model->meeting_end_time = $data['end_time'];
            $check_slot = $this->common_transaction_model->common_set_meeting($type = 'set', $user_data, $data['event_id'], $data['target_id'], $data['target_type']); //$this->model->check_slot($data['attendee_id'],$data['start_time'],$data['end_time']);
            //display($check_slot);

            if ($check_slot['check_slot']) {
                $json_array['error'] = 'error';
                $json_array['msg'] = 'This slot is not available.';
                json_output($json_array);
            }
            //$set_meeting                                                        = $this->model->set_meeting($data);
            if ($check_slot['set_meeting']) {
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Meeting Set successfully! wating for approval';
            }
        }
        json_output($json_array);
    }

    function reply_meeting() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $data['event_id'] = $this->input->post('event_id');
        $data['meeting_id'] = $this->input->post('meeting_id');
        $data['meeting_reply_text'] = $this->input->post('meeting_reply_text');
        $data['target_id'] = $this->input->post('target_id');
        $data['target_type'] = $this->input->post('target_type');
        $data['responce'] = $this->input->post('responce_type');
        $data['attendee_id'] = $user_data->attendee_id;
        $data['attendee_type'] = $user_data->attendee_type;
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something went Wrong!';
        $get_organizer = $this->model->getOrganizer(NULL, $data['event_id']);
        $get_meeting = $this->notification_model->getMeeting($data['meeting_id']);
        //show_query();
        //display($get_meeting);
        if ($data['target_id'] && $data['meeting_id'] && $data['attendee_id'] && $data['responce']) {
            $this->common_transaction_model->meeting_responce = $data['responce'];
            $this->common_transaction_model->meeting_id = $data['meeting_id'];
            $this->common_transaction_model->message = $data['meeting_reply_text'];
            $this->common_transaction_model->meeting_start_time = $get_meeting->start_time;
            $this->common_transaction_model->meeting_end_time = $get_meeting->start_time;
            $reply_meeting = $this->common_transaction_model->common_set_meeting($type = 'reply', $user_data, $data['event_id'], $data['target_id'], $data['target_type']); //$this->model->reply_meeting($data);

            if ($reply_meeting['reply_meeting']) {
                $json_array['error'] = 'success';
                $json_array['msg'] = $reply_meeting['reply_meeting'];
            }
        }

        json_output($json_array);
    }

    function download() {
        $this->load->helper('download');
        $type = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $file_name = $this->uri->segment(6);
        if ($type == 'S') {
            $path = 'speaker';
            $donload_name = 'Profile.pdf';
        } elseif ($type == 'E') {
            $path = 'exhibitor/brochure';
            $donload_name = 'broture.pdf';
        } elseif ($type == 'EVENT') {
            $path = 'events/floorplan';
            $donload_name = 'Event_map.pdf';
        } elseif ($type == 'SESSION') {
            $path = 'session';
            $donload_name = 'Event_map.pdf';
        }

        if (!file_exists(UPLOADS . "uploads/" . $path . "/" . $file_name) && !$file_name) {
            $json_array['error'] = 'error';
            $json_array['msg'] = 'File not Found on the server';

            json_output($json_array);
        }
        $data = file_get_contents(SITE_URL . "uploads/" . $path . "/" . $file_name); // Read the file's contents
        $name = $file_name;
        push_api_analytics('download', $subject_id, ucwords(strtolower($type)));
        force_download($name, $data);
    }

    function search_user() {
        $user_type = $this->input->get('type', TRUE);
        $event_id = $this->input->get('event_id', TRUE);
        $keyword = mysql_real_escape_string($this->input->get('term', TRUE));
        $data['user'] = array();
        if ($user_type) {
            if ($user_type == 'attendee') {
                $this->model->search = $keyword;
                $this->model->limit = 15;
                $data['user'] = $this->model->getAttendee(NULL, $event_id);
            } elseif ($user_type == 'exhibitor') {
                $this->model->search = $keyword;
                $this->model->limit = 15;
                $data['user'] = $this->model->getExhibitor(NULL, $event_id);
            }
        }

        json_output($data);
    }

    function get_social_notification() {
        $api_access_token = $this->uri->segment(4);
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        //display($use);
        $event_id = $this->uri->segment(5);
        $attendee_id = $user_data->attendee_id;
        $data['error'] = 'error';
        $data['msg'] = 'Something Went Wrong';
        if (!$attendee_id)
            return FALSE;
        $data['error'] = 'success';
        $data['msg'] = 'Success';
        $data['notification'] = $this->notification_model->socialNotificationCount($attendee_id, $event_id);

        json_output($data);
    }

    function update_social_notification() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $attendee_id = $user_data->attendee_id;
        $event_id = $this->input->post('event_id');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something went wrong';
        if (!$attendee_id && !$event_id)
            return;
        $this->db->where('attendee_id', $attendee_id);
        $this->db->where('event_id', $event_id);
        $this->db->update('event_has_attendee', array('rightside_social_notification' => 1));
        $json_array['error'] = 'success';
        $json_array['msg'] = 'Success';
        json_output($json_array);
    }

    ########################################################################SOCIAL LOGIN###########################################################

    function fb_login() {
        $data['social_type'] = 'facebook';
        $data['functionality_id'] = array();
        $data['industry_id'] = array();
        $data['fb_id'] = $this->input->post('fb_id');
        $data['email'] = $this->input->post('email');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['profile_pic'] = $this->input->post('profile_pic');
        $data['public_profile_url'] = $this->input->post('public_profile_url');
        $data['company'] = '';
        $data['designation'] = '';
        $data['city'] = '';
        $data['country'] = '';
        $data['location'] = '';
        //$data['description']                                                    = '';  
        $data['type_of_attendee'] = 'A';
        if (!$data['email']) {
            if (!$data['fb_id']) {
                $data['email'] = $data['fb_id'] . '@facebook.com';
            }
        }
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        $user_data = $this->login_model->check_user(NULL, $data['email'], $row = TRUE); //check for user
        if (!$user_data) {
            if ($data['fb_id']) {
                if ($data['profile_pic']) {
                    $url = $data['profile_pic'];
                    $image_data = @file_get_contents($url);
                    $fileName = $data['fb_id'] . 'facebook.jpg';
                    $save_path = UPLOADS . 'attendee/';
                    file_put_contents($save_path . $fileName, $image_data);
                    $profile_pic = $data['profile_pic'] = $fileName;
                }
                $save_user = $this->login_model->save_user(NULL, $data);
                //update to get the access token

                $this->db->where('id', $save_user['attendee_id']);
                $this->db->update('attendee', array('api_access_token' => md5($save_user['attendee_id'])));
                $user_data = check_access_token(md5($save_user['attendee_id']), $check_null = TRUE);
                $json_array['user_data'] = $user_data;
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Success';
            }
        } else {
            if ($data['profile_pic']) {
                $url = $data['profile_pic'];
                $image_data = @file_get_contents($url);
                $fileName = $data['fb_id'] . 'facebook.jpg';
                $save_path = UPLOADS . 'attendee/';
                file_put_contents($save_path . $fileName, $image_data);
                $profile_pic = $data['profile_pic'] = $fileName;
            }
            //if(!$user_data->facebook)
            {
                $this->login_model->attendee_id = $user_data->attendee_id;
                $save_user = $this->login_model->save_user($user_data->id, $data);
            }
            $user_data = check_access_token($user_data->api_access_token, $check_null = TRUE);
            $event_list = $this->event_list();
            $json_array = $event_list;
            $wall_notification_list = $this->notification_model->getwallNotification();
            $json_array['wall_notification'] = $wall_notification_list;
            $json_array['user_data'] = $user_data;
            $json_array['user_event_list'] = $this->model->get_user_event_list(@$user_data->attendee_id);
            $json_array['user_saved_attendee'] = $this->model->get_saved_profile_id(@$user_data->attendee_id, 'A');
            $json_array['user_saved_exhibitor'] = $this->model->get_saved_profile_id(@$user_data->attendee_id, 'E');
            $json_array['user_saved_speaker'] = $this->model->get_saved_profile_id(@$user_data->attendee_id, 'S');
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Success';
        }


        json_output($json_array);
    }

    function linkedin_login() {
        $data['social_type'] = 'linkedin';
        $data['functionality_id'] = array();
        $data['linkedin_id'] = $this->input->post('linkedin_id');
        $data['email'] = $this->input->post('email');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['profile_pic'] = $this->input->post('profile_pic');
        $data['industry'] = $this->input->post('industry');
        $data['company'] = $this->input->post('company');
        $data['designation'] = $this->input->post('designation');
        //$data['position']                                                       = json_decode(json_decode(json_encode($this->input->post('position'))), true);
        $data['skills'] = @json_decode(json_decode(json_encode($this->input->post('skills'))), true);
        $data['location'] = json_decode(json_decode(json_encode($this->input->post('location'))), true);
        $data['public_profile_url'] = $this->input->post('public_profile_url');
        $data['type_of_attendee'] = 'A';
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        //display((array)(stripslashes($this->input->post('position'))));exit;
        if ($data['email']) {
            $data['location'] = @$data['location']['name'];
            $temp = explode(',', $data['location']);
            $data['city'] = @$temp[0];
            $data['country'] = @$temp[1];
            $data['description'] = @$data['position']['values'][1]['summary'];
            if ($data['industry'])
                $data['industry_id'][] = $this->check_industry($data['industry']);
            else
                $data['industry_id'] = array();
            if ($data['skills'] && !is_null($data['skills']))
                $functions = $data['skills'];
            else
                $functions = array();
            //display((array)$functions);exit;
            if ((array) $functions && !empty($functions)) {
                foreach ($functions as $k => $v) {
                    $data['functionality_id'][] = $this->check_functionality($v['skill']['name']);
                }
            } else
                $data['functionality_id'] = array();
            $user_data = $this->login_model->check_user(NULL, $data['email'], $row = TRUE);
            //display($data);exit;
            if ($data['profile_pic']) {
                $url = $data['profile_pic'];
                $image_data = file_get_contents($url);
                $fileName = $data['linkedin_id'] . '_linkdin.jpg';
                $save_path = UPLOADS . 'attendee/';
                file_put_contents($save_path . $fileName, $image_data);
                $profile_pic = $data['profile_pic'] = $fileName;
            }
            //display($user_data);
            if (!$user_data) {
                $save_user = $this->login_model->save_user(NULL, $data);
                $this->db->where('id', $save_user['attendee_id']);
                $this->db->update('attendee', array('api_access_token' => md5($save_user['attendee_id'])));
                $user_data = check_access_token(md5($save_user['attendee_id']), $check_null = TRUE);
                $json_array['user_data'] = $user_data;
            } else {
                $this->login_model->attendee_id = $user_data->attendee_id;
                $user_data_update = $this->login_model->save_user($user_data->id, $data);
                //if(!$user_data->api_access_token)
                {
                    $this->db->where('id', $user_data->attendee_id);
                    $this->db->update('attendee', array('api_access_token' => md5($user_data->attendee_id)));
                }
                $user_data = check_access_token($user_data->api_access_token, $check_null = TRUE);
                $event_list = $this->event_list();
                $json_array = $event_list;
                $wall_notification_list = $this->notification_model->getwallNotification();
                $json_array['wall_notification'] = $wall_notification_list;
                $json_array['user_data'] = $user_data;
            }

            //redirect(SITE_URL.'API/event_api_call/linkedin_success/'.@$user_data->api_access_token);

            $json_array['api_access_token'] = $user_data->api_access_token;
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Success';
        }
        json_output($json_array);
    }

    function linkedin_pop_up() {
        $this->load->view('API/linkedin_login_view');
    }

    function linkedin_auth_success() {
        //$this->load->view('API/linkedin_login_auth_success_view');
    }

    function linkedin_success() {
        
    }

    //analytic part
    function check_industry($industry_data) {
        $check_industry = $this->model->getIndustry(NULL, $industry_data);
        if ($check_industry)
            $industry = $check_industry[0]['id'];

        if (!$check_industry) {
            $industry = $this->login_model->save_industry_functionality('industry', $industry_data); //$check_industry;
        }

        return $industry;
    }

    function check_functionality($functionality_data) {
        $check_functionality = $this->model->getFunctionality(NULL, $functionality_data);

        if ($check_functionality)
            $functionality = $check_functionality[0]['id'];

        if (!$check_functionality) {
            $functionality = $this->login_model->save_industry_functionality('functionality', $functionality_data); //$check_industry;
        }

        return $functionality;
    }

    function push_analytics() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $attndee_id = $user_data->attendee_id;
        $attndee_type = $user_data->attendee_type;
        $analytic_type = $this->input->post('analytic_type');
        $target_id = $this->input->post('target_id');
        $target_type = $this->input->post('target_type');
        $event_id = $this->input->post('event_id');
        $this->model->push_analytics($analytic_type, $attndee_id, $attndee_type, $target_id, $target_type, $event_id);
        $json_array['error'] = 'success';
        $json_array['msg'] = 'analytics data pushed successfully';
        json_output($json_array);
    }

    function push_ad_analytics() {
        $api_access_token = $this->input->post('api_access_token');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $object_id = $user_data->attendee_id;
        $object_type = $user_data->attendee_type;
        $ad_type = $this->input->post('ad_type');
        $ad_id = $this->input->post('ad_id');
        $event_id = $this->input->post('event_id');

        if ($object_id && $object_type && $ad_type && $ad_id) {
            $this->model->push_ad_analytics($object_id, $object_type, $ad_type, $ad_id, $event_id);
        }

        $json_array['error'] = 'success';
        $json_array['msg'] = 'analytics data pushed successfully';
        json_output($json_array);
    }

    function app_sync_flag() {
        $api_access_token = $this->input->post('api_access_token');
        $last_sync_time = $this->input->post('last_sync_time');
        $user_data = check_access_token($api_access_token, $check_null = TRUE);
        $last_app_sync_db = $this->notification_model->app_sync_flag($user_data->attendee_id);
        //echo $last_app_sync_db->last_app_sync_time;
        //echo date('Y-m-d H:i:s', strtotime($last_app_sync_db->last_app_sync_time.'+330 minutes'));
        $json_array['sync_flag'] = FALSE;
        if ($last_app_sync_db && $last_sync_time) {
            $date = new DateTime($last_app_sync_db->last_app_sync_time);
            $date->add(new DateInterval('PT5H30M'));
            $db_date = $date->format('Y-m-d H:i:s');
            //$db_date = $last_app_sync_db->last_app_sync_time;
            if (strtotime($db_date) > strtotime($last_sync_time)) {

                $json_array['sync_flag'] = TRUE;
            }
        }
        json_output($json_array);
    }

    function getAttendeeType($attendee_id) {
        if ($attendee_id) {
            $query = $this->db
                            ->select('attendee_type')
                            ->from('attendee')
                            ->where('id', $attendee_id)
                            ->get()->row();
            return @$query->attendee_type;
        }
    }

}
