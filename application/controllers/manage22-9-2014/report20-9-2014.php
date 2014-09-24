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
    function __construct() {
        parent::__construct();
        $this->load->model('report_model', 'model');
        $this->load->model('attendee_model');
        $this->load->model('sponsor_model');
        $this->load->model('exhibitor_model');
    }

    function generate_report()
    {
        $report_page_array = $this->report_page_array();
        $report_page = $this->uri->segment(4);
        if (!in_array($report_page, $report_page_array))
            redirect(SITE_URL.'manage/index');
        $report_for = $this->uri->segment(5);
        $organizer_id = $this->uri->segment(6);
        $event_id = $this->uri->segment(7);
        
        switch ($report_page) {
            case 'total_audience':
                $get_data = $this->total_audience($report_for,$organizer_id,$event_id);
                break;
            case 'fetured':
                $get_data = $this->fetured($report_for,$organizer_id,$event_id);
                break;
            case 'communication':
                $get_data = $this->communication($report_for,$organizer_id,$event_id);
                break;
            case 'profile_viewed':
                $get_data = $this->profile_viewed($report_for,$organizer_id,$event_id);
                break;
            case 'profile_saved':
                $get_data = $this->profile_saved($report_for,$organizer_id,$event_id);
                break;
            case 'profile_shared':
                $get_data = $this->profile_shared($report_for,$organizer_id,$event_id);
                break;
            case 'profile_download':
                $get_data = $this->profile_download($report_for,$organizer_id,$event_id);
                break;
            case 'app_used_by_user':
                $get_data = $this->app_used_by_user($report_for,$organizer_id,$event_id);
                break;
            case 'session':
                $get_data = $this->session($report_for,$organizer_id,$event_id);
                break;

        }
        //$get_data = $this->$report_page.'()';
    }
    function report_page_array()
    {
        $array = array(
                        'total_audience',
                        'fetured',
                        'communication',
                        'profile_viewed',
                        'profile_saved',
                        'profile_shared',
                        'profile_download',
                        'app_used_by_user',
                        'session',
                        );
        return $array;
    }
    function total_audience($report_for,$organizer_id,$event_id)
    {
        echo $report_for;
        
        switch ($report_for) {
            case 'attendee':
                $get_attendee = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                display($get_attendee);
                $excel_column = "Attendee ID\t Attendee Name\t Attendee Type\n";
                if($get_attendee)
                {
                    foreach($get_attendee as $attendee)
                    {
                        //if($attendee['attendee_type'] == 'A')
                        $excel_column .= $attendee['attendee_id']."\t".$attendee['name']."\t".$attendee['attendee_type']."\n";
                    }
                    $this->download_excel('attendee_report.xls',$excel_column);
                }
                break;
            case 'exhibitor':
                break;
                
            case 'speaker':
                $this->attendee_model->attendee_type = 'S';
                $get_attendee = $this->attendee_model->getAll($event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
                //display($get_attendee);
                $excel_column = "Attendee ID\t Attendee Name\t Attendee Type\n";
                if($get_attendee)
                {
                    foreach($get_attendee as $attendee)
                    {
                        if($attendee['attendee_type'] == 'S')
                        $excel_column .= $attendee['attendee_id']."\t".$attendee['name']."\t".$attendee['attendee_type']."\n";
                    }
                    
                }
                $this->download_excel('speaker_report.xls',$excel_column);
                break;

   
        }
    }
    
    function fetured($report_for,$organizer_id,$event_id)
    {
        switch ($report_for) {
            case 'exhibitors':
                $arr_exhibitors = $this->exhibitor_model->getAll($event_id, false, null, array(), 'exhibitor.event_id');
                $excel_column = "Name \t Stall No\t Mail Sent\t Link\n";
                if($arr_exhibitors)
                {
                    foreach($arr_exhibitors as $exh)
                    {
                        if($exh['is_featured'] == 1)
                        $excel_column .= $exh['name']."\t ".$exh['stall_number']."\t".$sponser['mail_sent']."\t".$sponser['link']."\n";
                    }
                }
                $this->download_excel('sponsor_report.xls',$excel_column);
                //display($arr_exhibitors);
                break;
            case 'sponsors':
                $arr_sponsor = $this->sponsor_model->getAll();
                $excel_column = "Name \t Normal Ad\t Splash Ad Type\t Link\n";
                if($arr_sponsor)
                {
                    foreach($arr_sponsor as $sponser)
                    {
                        //if($attendee['attendee_type'] == 'S')
                        $excel_column .= $sponser['sponser_name']."\t ".$sponser['normal_ad']."\t".$sponser['splash_ad']."\t".$sponser['link']."\n";
                    }
                    
                }
                $this->download_excel('sponsor_report.xls',$excel_column);
                //display($arr_sponsor);
                break;
        }
        
    }
    
    function communication($report_for,$organizer_id,$event_id)
    {
        switch ($report_for) {
            case 'messages':
                $get_data = $this->model->notification_user('Msg',$event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if($get_data)
                {
                    foreach($get_data as $att)
                    {
                        $excel_column .= $att['sender_type']."\t".$att['sender_name']."\t".$att['sender_company']."\t".$att['sender_designation']."\t".
                                        $att['receiver_type']."\t".$att['receiver_name']."\t".$att['receiver_company']."\t".$att['receiver_designation']."\t".$att['created_date']."\n";
                    }
                    
                }
                $this->download_excel('messages_report.xls',$excel_column);
                break;
            case 'broadcasts':
                $get_data = $this->model->notification_user('broadcasts',$event_id);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Action Date \n";
                if($get_data)
                {
                    foreach($get_data as $att)
                    {
                        $excel_column .= $att['sender_type']."\t".$att['sender_name']."\t".$att['sender_company']."\t".$att['sender_designation']."\t".
                                        $att['created_date']."\n";
                    }
                    
                }
                $this->download_excel('bradcasts_report.xls',$excel_column);
                break;
            case 'meetings':
                $get_data = $this->model->notification_user('Mtg',$event_id);
                //echo count($get_data);
                display($get_data);
                $excel_column = "Sender Type\t Sender Name \t Sender Company\t Sender Designation \t Receiver Type\t Receiver Name \t Receiver Company \t Receiver Designation \t Action Date \n";
                if($get_data)
                {
                    foreach($get_data as $att)
                    {
                        $excel_column .= $att['sender_type']."\t".$att['sender_name']."\t".$att['sender_company']."\t".$att['sender_designation']."\t".
                                        $att['receiver_type']."\t".$att['receiver_name']."\t".$att['receiver_company']."\t".$att['receiver_designation']."\t".$att['created_date']."\n";
                    }
                    
                }
                $this->download_excel('meetings_report.xls',$excel_column);
                break;
            case 'alerts':
                $get_data = $this->model->notification_user('A',$event_id);
                echo count($get_data);
                
                break;
            case 'feedback':    
                $get_data = $this->model->notification_user('F',$event_id);
                echo count($get_data);
                break;
            case 'notification':
                break;
        }
    }
    function profile_viewed($report_for,$organizer_id,$event_id)
    {
        
        switch ($report_for) {
            
            case 'attendee':
                $get_data = $this->model->get_analytics('A',$event_id);
                show_query();
                echo count($get_data);
                //display($get_data);
                break;
            case 'exhibitor':
                $get_data = $this->model->get_analytics('E',$event_id);
                show_query();
                echo count($get_data);
                break;
            case 'speaker':
                $get_data = $this->model->get_analytics('S',$event_id);
                show_query();
                echo count($get_data);
                break;
        }
    }
    
    function profile_saved($report_for,$organizer_id,$event_id)
    {
        
        switch ($report_for) {
            
            case 'attendee':
                $this->model->attendee_type = 'A';
                $get_data = $this->model->notification_user('Sav',$event_id);
                show_query();
                echo count($get_data);
                //display($get_data);
                break;
            case 'exhibitor':
                $this->model->attendee_type = 'E';
                $get_data = $this->model->notification_user('Sav',$event_id);
                show_query();
                echo count($get_data);
                break;
            case 'speaker':
                $this->model->attendee_type = 'S';
                $get_data = $this->model->notification_user('Sav',$event_id);
                show_query();
                echo count($get_data);
                break;
        }
    }
    
    function profile_shared($report_for,$organizer_id,$event_id)
    {
        switch ($report_for) {
            
            case 'attendee':
                $this->model->attendee_type = 'A';
                $get_data = $this->model->notification_user('Sh',$event_id);
                show_query();
                echo count($get_data);
                //display($get_data);
                break;
            case 'exhibitor':
                $this->model->attendee_type = 'E';
                $get_data = $this->model->notification_user('Sh',$event_id);
                show_query();
                echo count($get_data);
                break;
            case 'speaker':
                $this->model->attendee_type = 'S';
                $get_data = $this->model->notification_user('Sh',$event_id);
                show_query();
                echo count($get_data);
                break;
        }
    }
    
    function profile_downloads()
    {
        
    }
    
    function session($report_for,$organizer_id,$event_id)
    {
        $get_data = $this->model->get_session($event_id);
        display($get_data);
        /*switch ($report_for) {
            
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
        }*/
    }
    
    
    function app_used_by_user($report_for,$organizer_id,$event_id)
    {
        $get_data = $this->model->get_user('app_used_by_user',$event_id);
        display($get_data);
    }
    function download_excel($report_name,$field_name)
    {
        $this->load->helper('download');
        force_download($report_name.'.xls',$field_name);
    }
    
    function get_event()
    {
        $organizer_id = $this->input->post('organizer_id');
        $get_organizer_event = $this->model->get_organizer_event($organizer_id);
        $json_array = array();
        if($get_organizer_event)
        {
            foreach($get_organizer_event as $k=>$event)
            {
                $json_array[$k]['event_id'] = $event['id'];
                $json_array[$k]['event_name'] = $event['name'];
            }
        }
        
        echo json_encode($json_array);
    }
    
    

}
