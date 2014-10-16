<?php

class Report extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Aatish Gore
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    public $event_id = '';

    function __construct() {
        parent::__construct();
        $this->load->model('report_model', 'model');
        $this->load->model('attendee_model');
        $this->load->model('sponsor_model');
        $this->load->model('exhibitor_model');
        $this->load->model('event_model');
    }

    function generate_report() {
        $report_page_array = $this->report_page_array();
        $report_page = $this->uri->segment(4);
        if (!in_array($report_page, $report_page_array))
            redirect(SITE_URL . 'manage/index');
        $report_for = $this->uri->segment(5);
        $organizer_id = $this->uri->segment(6);
        $event_id = $this->uri->segment(7);
        $this->event_id = $event_id;
        switch ($report_page) {
            case 'total_audience':
                $get_data = $this->total_audience($report_for, $organizer_id, $event_id);
                break;
            case 'fetured':
                $get_data = $this->fetured($report_for, $organizer_id, $event_id);
                break;
            case 'communication':
                $get_data = $this->communication($report_for, $organizer_id, $event_id);
                break;
            case 'profile_viewed':
                $get_data = $this->profile_viewed($report_for, $organizer_id, $event_id);
                break;
            case 'profile_saved':
                $get_data = $this->profile_saved($report_for, $organizer_id, $event_id);
                break;
            case 'profile_shared':
                $get_data = $this->profile_shared($report_for, $organizer_id, $event_id);
                break;
            case 'profile_download':
                $get_data = $this->profile_download($report_for, $organizer_id, $event_id);
                break;
            case 'app_used_by_user':
                $get_data = $this->app_used_by_user($report_for, $organizer_id, $event_id);
                break;
            case 'get_user_signed_into_app':
                $get_data = $this->get_user_signed_into_app($report_for, $organizer_id, $event_id);
                break;
            case 'attendee_event_visit':
                $get_data = $this->attendee_event_visit($report_for, $organizer_id, $event_id);
                break;
            case 'session':
                $get_data = $this->session($report_for, $organizer_id, $event_id);
                break;
        }
        //$get_data = $this->$report_page.'()';
    }

    function report_page_array() {
        $array = array(
            'total_audience',
            'fetured',
            'communication',
            'profile_viewed',
            'profile_saved',
            'profile_shared',
            'profile_download',
            'app_used_by_user',
            'get_user_signed_into_app',
            'attendee_event_visit',
            'session',
        );
        return $array;
    }

    function total_audience($report_for, $organizer_id, $event_id) {
        //echo $report_for;
        switch ($report_for) {
            case 'attendee':
                $get_attendee = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                //display($get_attendee);
                $excel_column = "Attendee Type\t Name\t Designation\t Company Name\t Email ID\t Mobile No\t Contact No\tAccessed App?\n";
                if ($get_attendee) {
                    foreach ($get_attendee as $attendee) {
                        //if($attendee['attendee_type'] == 'A')
                        $sender_type = $this->get_user_type($attendee['attendee_type']);
                        $attendee_status = 'No';
                        if ($attendee['attendee_status'] == 1)
                            $attendee_status = 'Yes';
                        $accessed_app = 'No';
                        if ($attendee['gcm_reg_id'] != "" || $attendee['gcm_reg_id'] != NULL)
                            $accessed_app = 'Yes';
                        $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . "\t" . $accessed_app . "\n";
                    }
                    $this->download_excel('attendee_report', $excel_column);
                }
                break;
            case 'exhibitor':
                $this->attendee_model->attendee_type = 'E';
                $get_attendee = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                //display($get_attendee);
                $excel_column = "Attendee Type\t Name\t Designation\t Company Name\t Email ID\t Mobile No\t Contact No\tAccessed App?\n";
                if ($get_attendee) {
                    foreach ($get_attendee as $attendee) {
                        //if($attendee['attendee_type'] == 'A')
                        if ($attendee['attendee_type'] != 'E') {
                            continue;
                        }
                        $sender_type = $this->get_user_type($attendee['attendee_type']);
                        $attendee_status = 'No';
                        if ($attendee['attendee_status'] == 1)
                            $attendee_status = 'Yes';
                        $accessed_app = 'No';
                        if ($attendee['gcm_reg_id'] != "" || $attendee['gcm_reg_id'] != NULL)
                            $accessed_app = 'Yes';
                        $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . "\t" . $accessed_app . "\n";
                    }
                    $this->download_excel('exhibitor_report', $excel_column);
                }
                break;

            case 'speaker':
                $this->attendee_model->attendee_type = 'S';
                $get_attendee = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                //display($get_attendee);
                //$excel_column = "Attendee Name\t Attendee Type\n";
                $excel_column = "Attendee Type\t Name\t Designation\t Company Name\t Email ID\t Mobile No\t Contact No\t Accessed App?\n";
                if ($get_attendee) {
                    foreach ($get_attendee as $attendee) {
                        if ($attendee['attendee_type'] != 'S') {
                            continue;
                        }
                        $sender_type = $this->get_user_type($attendee['attendee_type']);
                        $attendee_status = 'No';
                        if ($attendee['attendee_status'] == 1)
                            $attendee_status = 'Yes';
                        $accessed_app = 'No';
                        if ($attendee['gcm_reg_id'] != "" || $attendee['gcm_reg_id'] != NULL)
                            $accessed_app = 'Yes';
                        $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $accessed_app . "\n";
                    }
                }
                $this->download_excel('speaker_report', $excel_column);
                break;
            case 'All':
                $get_attendee = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                //display($get_attendee);
                //$excel_column = "Attendee Name\t Attendee Type\n";
                $excel_column = "Attendee Type\t Name\t Designation\t Company Name\t Email ID\t Mobile No\t Contact No\t Accessed App?\n";
                if ($get_attendee) {
                    foreach ($get_attendee as $attendee) {
                        $sender_type = $this->get_user_type($attendee['attendee_type']);
                        $attendee_status = 'No';
                        if ($attendee['attendee_status'] == 1)
                            $attendee_status = 'Yes';
                        $accessed_app = 'No';
                        if ($attendee['gcm_reg_id'] != "" || $attendee['gcm_reg_id'] != NULL)
                            $accessed_app = 'Yes';
                        $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $accessed_app . "\n";
                    }
                    $this->attendee_model->attendee_type = 'S';
                    $get_speaker = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                    if ($get_speaker) {
                        foreach ($get_speaker as $attendee) {
                            $sender_type = $this->get_user_type($attendee['attendee_type']);
                            $attendee_status = 'No';
                            if ($attendee['attendee_status'] == 1)
                                $attendee_status = 'Yes';
                            $accessed_app = 'No';
                            if ($attendee['gcm_reg_id'] != "" || $attendee['gcm_reg_id'] != NULL)
                                $accessed_app = 'Yes';
                            $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $accessed_app . "\n";
                        }
                    }
                }
                $this->download_excel('total_audience_report', $excel_column);
                break;
        }
    }

    function fetured($report_for, $organizer_id, $event_id) {
        switch ($report_for) {
            case 'exhibitors':
                $arr_exhibitors = $this->exhibitor_model->getAll($event_id, false, null, array(), 'exhibitor.event_id');
                $excel_column = "Name \t Stall No\t Mail Sent\t Link\n";
                if ($arr_exhibitors) {
                    foreach ($arr_exhibitors as $exh) {
                        if ($exh['is_featured'] == 1)
                            $excel_column .= $exh['name'] . "\t " . $exh['stall_number'] . "\t" . $sponser['mail_sent'] . "\t" . $sponser['link'] . "\n";
                    }
                }
                $this->download_excel('sponsor_report', $excel_column);
                break;
            case 'sponsors':
                $arr_sponsor = $this->sponsor_model->getAll();
                $excel_column = "Name \t Normal Ad\t Splash Ad Type\t Link\n";
                if ($arr_sponsor) {
                    foreach ($arr_sponsor as $sponser) {
                        $excel_column .= $sponser['sponser_name'] . "\t " . $sponser['normal_ad'] . "\t" . $sponser['splash_ad'] . "\t" . $sponser['link'] . "\n";
                    }
                }
                $this->download_excel('sponsor_report', $excel_column);
                break;
        }
    }

    function communication($report_for, $organizer_id, $event_id) {
        switch ($report_for) {
            case 'messages':
                $get_data = $this->model->notification_user('Msg', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('messages_report', $excel_column);
                break;
            case 'broadcasts':
                $get_data = $this->model->notification_user('broadcasts', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Designation \t Sender Company \t Broadcast Message \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_designation'] . "\t" . $att['sender_company'] . "\t" . $att['content'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('bradcasts_report', $excel_column);
                break;
            case 'meetings':
                $get_data = $this->model->notification_user('Mtg', $event_id);
                //echo count($get_data);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('meetings_report', $excel_column);
                break;
            case 'alerts':
                $get_data = $this->model->notification_user('A', $event_id);
                $excel_column = "Alert Message\t Alert Sent Count \t Alert Read Count \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $excel_column .= $att['content'] . "\t" . $att['notification_total_count'] . "\t" . $att['notification_read_count'] . "\n";
                    }
                }
                $this->download_excel('alert_report', $excel_column);
                break;
            case 'feedback':
                $get_data = $this->model->notification_user('F', $event_id);
                $excel_column = "Feedback Message\t Feedback Sent Count \t Count of People Responded \t Average Rating \n";
                if ($get_data) {

                    foreach ($get_data as $att) {
                        $average_rating = 0;
                        if ($att['total'] != 0)
                            $average_rating = $att['star'] / $att['total'];
                        $excel_column .= $att['content'] . "\t" . $att['star'] . "\t" . $att['total'] . "\t" . $average_rating . "\n";
                    }
                }
                $this->download_excel('feedback_report', $excel_column);
                break;
            case 'notification':
                $get_data = $this->model->notification_user('N', $event_id);
                $excel_column = "Notification Message\t Notification Sent Count \t Notification Read Count \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $excel_column .= $att['content'] . "\t" . $att['notification_total_count'] . "\t" . $att['notification_read_count'] . "\n";
                    }
                }
                $this->download_excel('notification_report', $excel_column);
                break;
        }
    }

    function profile_viewed($report_for, $organizer_id, $event_id) {

        switch ($report_for) {

            case 'attendee':
                $get_data = $this->model->get_analytics('A', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_view_attendee_report', $excel_column);
                break;
            case 'exhibitor':
                $get_data = $this->model->get_analytics('E', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_view_exhibitor_report', $excel_column);
                break;
            case 'speaker':
                $get_data = $this->model->get_analytics('S', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_view_speaker_report', $excel_column);
                break;
            case 'All':
                $get_attendee_data = $this->model->get_analytics('A', $event_id);
                $get_exhibitor_data = $this->model->get_analytics('E', $event_id);
                $get_speaker_data = $this->model->get_analytics('S', $event_id);
                $get_data = array_merge($get_attendee_data, $get_exhibitor_data);
                $get_data = array_merge($get_data, $get_speaker_data);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_view_report', $excel_column);
                break;
        }
    }

    function profile_saved($report_for, $organizer_id, $event_id) {

        switch ($report_for) {

            case 'attendee':
                $this->model->attendee_type = 'A';
                $get_data = $this->model->notification_user('Sav', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_saved_attendee_report', $excel_column);
                break;
            case 'exhibitor':
                $this->model->attendee_type = 'E';
                $get_data = $this->model->notification_user('Sav', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_saved_exhibitor_report', $excel_column);
                break;
            case 'speaker':
                $this->model->attendee_type = 'S';
                $get_data = $this->model->notification_user('Sav', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_saved_speaker_report', $excel_column);
                break;
            case 'All':
                $get_data = $this->model->notification_user('Sav', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_saved_report', $excel_column);
                break;
        }
    }

    function profile_shared($report_for, $organizer_id, $event_id) {
        switch ($report_for) {

            case 'attendee':
                $this->model->attendee_type = 'A';
                $get_data = $this->model->notification_user('Sh', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_shared_attendee_report', $excel_column);
                break;
            case 'exhibitor':
                $this->model->attendee_type = 'E';
                $get_data = $this->model->notification_user('Sh', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_shared_exhibitor_report', $excel_column);
                break;
            case 'speaker':
                $this->model->attendee_type = 'S';
                $get_data = $this->model->notification_user('Sh', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_shared_speaker_report', $excel_column);
                break;
            case 'All':
                $get_data = $this->model->notification_user('Sh', $event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        if ($att['receiver_type'] == "" || empty($att['receiver_type'])) {
                            continue;
                        }
                        $excel_column .= $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_company'] . "\t" . $att['sender_designation'] . "\t" .
                                $receiver_type . "\t" . $att['receiver_name'] . "\t" . $att['receiver_company'] . "\t" . $att['receiver_designation'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_shared_report', $excel_column);
                break;
        }
    }

    function profile_download($report_for, $organizer_id, $event_id) {
//        $type_array = array('download', 'download_evt_map', 'download_ses_pro', 'download_exe_pro', 'download_exh_pro');
        switch ($report_for) {
            case 'All':
                $get_data = $this->model->get_download_analytics('All', $event_id);
                $excel_column = " Type \t From Attendee Type \t From Name \t Designation \t Company Name \t To Attendee Type \t To Name / Session Name \t Designation \t Company Name\t Created \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $download_type = $this->get_download_type($att['type']);
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        if ($download_type == 'Event Map') {
                            $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_designation'] . "\t" .
                                    $att['sender_company'] . "\t" . '-' . "\t" . '-' . "\t" .
                                    '-' . "\t" . '-' . "\t" . $att['created_date'] . "\n";
                        } else {
                            if ($download_type == 'Session Profile') {
                                $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att ['sender_designation'] . "\t" .
                                        $att['sender_company'] . "\t" . 'Session' . "\t" . $att['session_name'] . "\t" .
                                        '-' . "\t" . '-' . "\t" . $att['created_date'] . "\n";
                            } else {
                                $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att['sender_designation'] . "\t" .
                                        $att['sender_company'] . "\t" . $receiver_type . "\t" . $att['receiver_name'] . "\t" .
                                        $att['receiver_designation'] . "\t" . $att['receiver_company'] . "\t" . $att['created_date'] . "\n";
                            }
                        }
                    }
                }
                $this->download_excel('All_profile_download_report', $excel_column);

                break;
            case 'download_evt_map':
                $get_data = $this->model->get_download_analytics('download_evt_map', $event_id);
                $excel_column = " Type \t From Attendee Type \t From Name \t Designation \t Company Name \t Created \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $download_type = $this->get_download_type($att['type']);
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att ['sender_designation'] . "\t" .
                                $att ['sender_company'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_download_event_map_report', $excel_column);
                break;
            case 'download_ses_map':
                $get_data = $this->model->get_download_analytics('download_ses_map', $event_id);
                $excel_column = " Type \t From Attendee Type \t From Name \t Designation \t Company Name \t Session Name \t Created \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $download_type = $this->get_download_type($att['type']);
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att ['sender_designation'] . "\t" .
                                $att['sender_company'] . "\t" . $att['session_name'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_download_session_report', $excel_column);
                break;
            case 'download_exh_pro':
                $get_data = $this->model->get_download_analytics('download_exh_pro', $event_id);
                $excel_column = " Type \t From Attendee Type \t From Name \t Designation \t Company Name \t To Attendee Type \t To Name / Session Name \t Designation \t Company Name\t Created \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $download_type = $this->get_download_type($att['type']);
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att ['sender_designation'] . "\t" .
                                $att['sender_company'] . "\t" . 'Exhibitor' . "\t" . $att['receiver_name'] . "\t" .
                                $att ['receiver_designation'] . "\t" . $att['receiver_company'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_download_exhibitor_report', $excel_column);
                break;
            case 'download_exe_pro':
                //*************************************************** Speaker *******************************
                $get_data = $this->model->get_download_analytics('download_exe_pro', $event_id);
                $excel_column = " Type \t From Attendee Type \t From Name \t Designation \t Company Name \t To Attendee Type \t To Name / Session Name \t Designation \t Company Name\t Created \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $download_type = $this->get_download_type($att['type']);
                        $sender_type = $this->get_user_type($att['sender_type']);
                        $receiver_type = $this->get_user_type($att['receiver_type']);
                        $excel_column .= $download_type . "\t" . $sender_type . "\t" . $att['sender_name'] . "\t" . $att ['sender_designation'] . "\t" .
                                $att['sender_company'] . "\t" . 'Speaker' . "\t" . $att['receiver_name'] . "\t" .
                                $att ['receiver_designation'] . "\t" . $att['receiver_company'] . "\t" . $att['created_date'] . "\n";
                    }
                }
                $this->download_excel('profile_download_speaker_report', $excel_column);

                break;
        }
    }

    function session($report_for, $organizer_id, $event_id) {
        $type = "";
        switch ($report_for) {
            case 'report':
                $type = 'report';
                $get_data = $this->model->get_session($event_id, $type);
                $excel_column = "Session Name\t Attendee Count \t Speaker Count\t Questions Asked \t Total feedback\t Average Feedback  \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $ave = 0;
                        if ($att['user_count'] != 0)
                            $ave = number_format($att['rating'] / $att['user_count'], 2);

                        $excel_column .= $att['name'] . "\t" . $att['attendee_count'] . "\t" . $att['speaker_count'] . "\t" . $att['question_count'] . "\t" .
                                $att['rating'] . "\t" . $ave . "\n";
                    }
                }
                $this->download_excel('session_report', $excel_column);
                break;
            case 'attendee':
                $get_data = $this->model->get_session($event_id, $type);
                $excel_column = "Session Name\t Attendee Type \t Name \t Designation \t Company Name \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        if ($att['attendee_type'] != 'A') {
                            continue;
                        }
                        $ave = 0;
                        $user_type = $this->get_user_type($att['attendee_type']);
                        if ($att['user_count'] != 0)
                            $ave = number_format($att['rating'] / $att['user_count'], 2);

                        $excel_column .= $att ['name'] . "\t" . $user_type . "\t" . $att['attendee_name'] . "\t" . $att['designation'] . "\t" .
                                $att['company_name'] . "\n";
                    }
                }
                $this->download_excel('session_report', $excel_column);
                break;
            case 'question':
                $type = 'question';
                $get_data = $this->model->get_session($event_id, $type);

                $excel_column = "Session Name\t Question \t Asked By \t Designation \t Company Name \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        $ave = 0;
                        if ($att['user_count'] != 0)
                            $ave = number_format($att['rating'] / $att['user_count'], 2);

                        $excel_column .= $att['name'] . "\t" . $att['question'] . "\t" . $att['attendee_name'] . "\t" . $att['designation'] . "\t" .
                                $att['company_name'] . "\n";
                    }
                }
                $this->download_excel('session_report', $excel_column);
                break;
            case 'speaker':
                $get_data = $this->model->get_session($event_id, $type);
                $excel_column = "Session Name\t Attendee Type \t Name \t Designation \t Company Name \n";
                if ($get_data) {
                    foreach ($get_data as $att) {
                        if ($att['attendee_type'] != 'S') {
                            continue;
                        }
                        $ave = 0;
                        $user_type = $this->get_user_type($att['attendee_type']);
                        if ($att['user_count'] != 0)
                            $ave = number_format($att['rating'] / $att['user_count'], 2);

                        $excel_column .= $att ['name'] . "\t" . $user_type . "\t" . $att['attendee_name'] . "\t" . $att['designation'] . "\t" .
                                $att['company_name'] . "\n";
                    }
                }
                $this->download_excel('session_report', $excel_column);
                break;
        }

        /* switch ($report_for) {

          case 'attendee':
          $this->model->attendee_type = 'A';
          $get_data = $this->model->session('Sh',$event_id);
          show_query();
          echo count($get_data);
          //display($get_data);
          break;
          case 'speaker':
          $this->model->attendee_type = 'S';
          $get_data = $this->model->notification_user('Sh',$event_id);
          show_query();
          echo count($get_data);
          break;
          } */
    }

    function app_used_by_user($report_for, $organizer_id, $event_id) {
        $get_data = $this->model->get_user('app_used_by_user', $event_id);
        $excel_column = "Attendee Type\t Attendee Name\t Designation\t Company Name\t  Email ID\t Mobile No\t Contact No \tAndroid\ios \n";
        if ($get_data) {
            foreach ($get_data as $attendee) {
                //if($attendee['attendee_type'] == 'A')
                $sender_type = $this->get_user_type($attendee['attendee_type']);

                $accessed_app = 'No';
                if ($attendee[
                        'gcm_reg_id'] == 1)
                    $accessed_app = 'Yes';
                $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee ['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $attendee['mobile_os'] . "\n";
            }
        }
        $this->download_excel('app_used_by_user_report', $excel_column);
        //display($get_data);
    }

    function get_user_signed_into_app($report_for, $organizer_id, $event_id) {
        $get_data = $this->model->get_user_signed_into_app('get_user_signed_into_app', $event_id);
        $excel_column = "Attendee Name\t Designation\t Company Name\t  Email ID\t Mobile No\t Contact No \tAndroid\ios \n";
        if ($get_data) {
            foreach ($get_data as $attendee) {
                //if($attendee['attendee_type'] == 'A')

                $accessed_app = 'No';
                if ($attendee[
                        'gcm_reg_id'] == 1)
                    $accessed_app = 'Yes';
                $excel_column .= $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee ['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $attendee['mobile_os'] . "\n";
            }
        }
        $this->download_excel('user_signed_into_app_report', $excel_column);
        //display($get_data);
    }

    function get_user_signed_in_app($report_for, $organizer_id, $event_id) {
        $get_data = $this->model->get_user_signed_in_app('get_user_signed_in_app', $event_id);
        $excel_column = "Attendee Type\t Attendee Name\t Designation\t Company Name\t  Email ID\t Mobile No\t Contact No \tAndroid\ios \n";
        if ($get_data) {
            foreach ($get_data as $attendee) {
                //if($attendee['attendee_type'] == 'A')
                $sender_type = $this->get_user_type($attendee['attendee_type']);

                $accessed_app = 'No';
                if ($attendee[
                        'gcm_reg_id'] == 1)
                    $accessed_app = 'Yes';
                $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee ['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $attendee['mobile_os'] . "\n";
            }
        }
        $this->download_excel('app_used_by_user_report', $excel_column);
        //display($get_data);
    }

    function attendee_event_visit($report_for, $organizer_id, $event_id) {
        $get_data = $this->model->get_user('user_event_visit', $event_id);
        //echo count($get_data);
        //show_query();
        //display($get_data);
        $excel_column = "Attendee Type\t Attendee Name\t Designation\t Company Name\t  Email ID\t Mobile No\t Contact No \tAndroid\ios \n";
        if ($get_data) {
            foreach ($get_data as $attendee) {
                //if($attendee['attendee_type'] == 'A')
                $sender_type = $this->get_user_type($attendee['attendee_type']);

                $accessed_app = 'No';
                if ($attendee[
                        'gcm_reg_id'] == 1)
                    $accessed_app = 'Yes';
                $excel_column .= $sender_type . "\t" . $attendee['name'] . "\t" . $attendee['designation'] . "\t" . $attendee ['company_name'] . "\t" . $attendee['email'] . "\t" . $attendee['mobile'] . "\t" . $attendee['phone'] . "\t" . $attendee['mobile_os'] . "\n";
            }
        }
        $this->download_excel(
                'attendee_event_visit', $excel_column);
    }

    function download_excel($report_name, $field_name) {
        $this->load->helper('download');
        $event_id = $this->event_id;
        $event_detail = $this->event_model->get($event_id, '1');
        if ($report_name == 'user_signed_into_app_report') {
            force_download($report_name .
                    '.xls', $field_name);
        } else {
            force_download($event_detail->name . "_" . $report_name .
                    '.xls', $field_name);
        }
    }

    function get_event() {
        $organizer_id = $this->input->post('organizer_id');
        $get_organizer_event = $this->model->get_organizer_event($organizer_id);
        $json_array = array();
        if ($get_organizer_event) {
            foreach ($get_organizer_event as $k => $event) {
                $json_array[$k]['event_id'] = $event['id'];
                $json_array[$k]['event_name'] = $event['name'];
            }
        }

        echo

        json_encode($json_array);
    }

    function get_user_type($user_type = NULL) {
        if ($user_type == 'A') {
            return 'Attendee';
        } else if ($user_type == 'E') {
            return 'Exhibitor';
        } else if ($user_type == 'S') {
            return 'Speaker';
        } else {
            return

                    $user_type;
        }
    }

    function get_download_type($user_type = NULL) {
        //        $type_array = array('download', 'download_evt_map', 'download_ses_pro', 'download_exe_pro', 'download_exh_pro');

        if ($user_type == 'download') {
            return 'Download';
        } else if ($user_type == 'download_evt_map') {
            return 'Event Map';
        } else if ($user_type == 'download_ses_map') {
            return 'Session Profile';
        } else if ($user_type == 'download_exe_pro') {
            return 'Speaker Profile';
        } else if ($user_type == 'download_exh_pro') {
            return 'Exhibitor Profile';
        } else {
            return $user_type;
        }
    }

}
