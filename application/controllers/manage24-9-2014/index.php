<?php

class Index extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Aatish Gore
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    public $event_id;

    function __construct() {
        parent::__construct();
        $type = $this->session->userdata('type_of_user');
        $superadmin = $this->session->userdata('is_superadmin');
        $user_id = $this->session->userdata('user_id');
        $arrEvents = getEvents($user_id, $superadmin, $type);
		
        if (count($arrEvents) > 0 && !$superadmin) {
            setcookie("event_id", $arrEvents[0]['event_id'], time() + 3600 * 3600, '/');
            $this->event_id = $arrEvents[0]['event_id'];
        }

        $this->load->model('attendee_model');
        $this->load->model('exhibitor_model');
        $this->load->model('speaker_model');
        $this->load->model('sponsor_model');
        $this->load->model('dashboard_model');
        $this->load->model('notification_model');
        $this->load->model('organizer_model');
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
    public function dashboard(){
		
        $arr_sponsor = $this->sponsor_model->getAll();
        $arrData['total_sponsor'] = $total_sponsor = count($arr_sponsor);

        $arr_exhibitors = $this->exhibitor_model->getAll($this->event_id, false, null, array(), 'exhibitor.event_id');
        $arrData['total_exhibitors'] = $total_exhibitors = count($arr_exhibitors);

		$where = "subject_type = 'Sp' AND analytics.event_id = {$this->event_id} AND analytics.type = 'Spl_hit'";
		$arr_splash_ad = $this->sponsor_model->get_sponsor_analytics($where);

		$where = "subject_type = 'Sp' AND analytics.event_id = {$this->event_id} AND analytics.type = 'Spo_hit'";
		$arr_spo_ad = $this->sponsor_model->get_sponsor_analytics($where);
		$arrData['arr_splash_ad'] = $arr_splash_ad;
		$arrData['arr_spo_ad'] = $arr_spo_ad;
		
	

        $featured = 0;
        foreach ($arr_exhibitors as $exh) {
            if ($exh['is_featured'] == 1)
                $featured++;
        }
        $arrData['featured_exhibtior'] = $featured;
        $arr_attendees = $this->attendee_model->getAll($this->event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');

        $arrData['total_attendees'] = $total_attendees = count($arr_attendees);

        $arr_speakers = $this->speaker_model->getAll($this->event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
        $arrData['total_speakers'] = $total_speakers = count($arr_speakers);

        $arr_where = array("event_id" => $this->event_id);
        $arrResult = $this->dashboard_model->getAll($arr_where);
        $arrExhId = array();
        $arrSpkId = array();
        $arrAtId = array();
        $download_evt_map = 0;
        $download_ses_pros = 0;
        $download_spe_pro = 0;
        $download_exh_pro = 0;
        $tou = 'A';
        $tos = 'industry';
        if ($this->input->post('type_of_user')) {
            $tou = $this->input->post('type_of_user');
        }
        if ($this->input->post('type_of_stat')) {
            $tos = $this->input->post('type_of_stat');
        }

        if ($tou == 'A')
            $arrData['interests'] = $arrInterest = $this->dashboard_model->getAttendeeInterest($tos);

        if ($tou == 'E')
            $arrData['interests'] = $arrInterest = $this->dashboard_model->getExhibitorInterest($tos);
//        echo $this->db->last_query();exit;
        if ($tou == 'S')
            $arrData['interests'] = $arrInterest = $this->dashboard_model->getAttendeeInterest($tos, 'speaker');
        $arrData['tos'] = $tos;
        $arrData['tou'] = $tou;

        $event_visit = 0;


        foreach ($arrResult as $res) {
            if ($res['subject_type'] == 'A' && $res['type'] == 'view')
                array_push($arrAtId, $res['subject_id']);
            if ($res['subject_type'] == 'S' && $res['type'] == 'view')
                array_push($arrSpkId, $res['subject_id']);
            if ($res['subject_type'] == 'E' && $res['type'] == 'view')
                array_push($arrExhId, $res['subject_id']);

            if ($res['subject_type'] == 'Event' && $res['type'] == 'view')
                $event_visit++;

            if ($res['type'] == 'download_evt_map')
                $download_evt_map++;
            if ($res['type'] == 'download_ses_map')
                $download_ses_pros++;
            if ($res['type'] == 'download_spe_map')
                $download_spe_pro++;
            if ($res['type'] == 'download_exe_map')
                $download_exh_pro++;
        }

        $facebook = 0;
        $linkden = 0;
        $manual = 0;
        foreach ($arr_attendees as $attends) {
            if ($attends['linkden'] == '' && $attends['facebook'] == '' && $attends['attendee_status'])
                $manual++;
            if ($attends['linkden'] != '')
                $linkden++;
            if ($attends['facebook'] != '')
                $facebook++;
        }
        $arrData['linkden'] = $linkden;
        $arrData['facebook'] = $facebook;
        $arrData['manual'] = $manual;

        $meetings = $this->dashboard_model->getMeeting();

        $no_of_meetings = count($meetings);
        $confirmed = 0;
        $declined = 0;
        $no_response = 0;
        if ($no_of_meetings != 0) {
            foreach ($meetings as $meet) {
                if ($meet['approve'] == 0)
                    $no_response++;

                if ($meet['approve'] == 1)
                    $confirmed++;

                if ($meet['approve'] == 2)
                    $declined++;
            }
        }
        $arrData['no_of_meetings'] = $no_of_meetings;
        $arrData['confirmed'] = $confirmed;
        $arrData['declined'] = $declined;
        $arrData['no_response'] = $no_response;

        $arrData['sessions'] = $arrSession = $this->dashboard_model->getSession();
//        echo '<pre>'.$this->db->last_query();exit;
//        echo '<pre>';print_r($arrSession);exit;

        $arrAttendee = $this->dashboard_model->getAttendee();
        $attendeeApp = 0;
        foreach ($arrAttendee as $eachAttendee) {
            if ($eachAttendee['status'] == 1)
                $attendeeApp++;
        }
        $registerAttendee = count($arrAttendee);

        $arrData['event_visit'] = $event_visit;
        $arrData['attendeeApp'] = $attendeeApp;
        $arrData['registerAttendee'] = $registerAttendee;


        $arrData['arr_exh_view'] = $arr_exh_view = count(array_unique($arrExhId));
        $arrData['arr_att_view'] = $arr_att_view = count(array_unique($arrAtId));
        $arrData['arr_spk_view'] = $arr_att_view = count(array_unique($arrSpkId));

        $arrData['download_evt_map'] = $download_evt_map;
        $arrData['download_ses_pros'] = $download_ses_pros;
        $arrData['download_spe_pro'] = $download_spe_pro;
        $arrData['download_exh_pro'] = $download_exh_pro;
		//echo  $this->event_id;
        $where = "object_type IN ('A','E','S','event','O') AND event_id = $this->event_id";
        $arrProfileView = $this->notification_model->getAll($where);
		//echo $this->db->last_query();
        $saveAttendee = 0;
        $saveExhibitor = 0;
        $saveSpeaker = 0;

        $sharedAttendee = 0;
        $sharedExhibitor = 0;
        $sharedSpeaker = 0;
        $sharedEvent = 0;

        $messages = 0;
        $broadcasts = 0;
        $communication_meeting = 0;
        $communication_feedback = 0;
        $communication_notification = 0;
        $alert = 0;
		//echo '<pre>';print_r($arrProfileView);exit;
        foreach ($arrProfileView as $profile) {
            if ($profile['subject_type'] == 'A' && $profile['type'] == 'Sav')
                $saveAttendee++;
            if ($profile['subject_type'] == 'E' && $profile['type'] == 'Sav')
                $saveExhibitor++;
            if ($profile['subject_type'] == 'S' && $profile['type'] == 'Sav')
                $saveSpeaker++;

           // if ($profile['subject_type'] == 'Event' && $profile['type'] == 'Sh')
             //   $sharedEvent++;
            if ($profile['subject_type'] == 'A' && $profile['type'] == 'Sh')
                $sharedAttendee++;
            if ($profile['subject_type'] == 'E' && $profile['type'] == 'Sh')
                $sharedExhibitor++;
            if ($profile['subject_type'] == 'S' && $profile['type'] == 'Sh')
                $sharedSpeaker++;



            if ($profile['type'] == 'Msg' && $profile['subject_type'] != '0')
                $messages++;

            if ($profile['type'] == 'Msg' && $profile['subject_type'] == '0')
                $broadcasts++;

            if ($profile['type'] == 'Mtg')
                $communication_meeting++;

            if ($profile['type'] == 'A')
                $alert++;

            if ($profile['type'] == 'F')
                $communication_feedback++;

            if ($profile['type'] == 'N')
                $communication_notification++;
        }
        $arrData['communication_notification'] = $communication_notification;
        $arrData['communication_feedback'] = $communication_feedback;
        $arrData['alert'] = $alert;
        $arrData['broadcasts'] = $broadcasts;
        $arrData['communication_meeting'] = $communication_meeting;
        $arrData['messages'] = $messages;


        $arrData['saveAttendee'] = $saveAttendee;
        $arrData['saveExhibitor'] = $saveExhibitor;
        $arrData['saveSpeaker'] = $saveSpeaker;

        $arrData['sharedAttendee'] = $sharedAttendee;
        $arrData['sharedExhibitor'] = $sharedExhibitor;
        $arrData['sharedSpeaker'] = $sharedSpeaker;
        $arrData['sharedEvent'] = $sharedEvent;

        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Analytics';
        $arrData['breadcrumb_tag'] = ' View all the event analytics here';
        $arrData['breadcrumb_class'] = 'fa-bar-chart-o';
//        $arrData['middle'] = 'admin/dashboard';
        $this->load->view('admin/analytics', $arrData);
    }
    
    public function index() {
		$type = $this->session->userdata('type_of_user');
        $superadmin = $this->session->userdata('is_superadmin');
        $user_id = $this->session->userdata('user_id');
		//echo $type;exit;
        if($type == 'E' && !$superadmin)
				            redirect ('manage/index/exdashboard');

        if($type != 'O' || $superadmin){
					
		$arrData['total_exhibitors'] = $total_exhibitors =  $this->dashboard_model->getCount('exhibitor');
		$arrData['total_exhibitors'] = $total_exhibitors[0]['cnt'];
		$where = "attendee_type = 'A'";
		$total_attendees =  $this->dashboard_model->getCount('attendee',$where);
		$arrData['total_attendees'] = $total_attendees[0]['cnt'];
		$where = "attendee_type = 'S'";
		$total_speakers = $this->dashboard_model->getCount('attendee',$where);
		$arrData['total_speakers'] = $total_speakers[0]['cnt'];

		$where = 'is_featured = 1';
		$featured_exhibtior = $this->dashboard_model->getCount('exhibitor',$where);
		$arrData['featured_exhibtior'] = $featured_exhibtior[0]['cnt'];

		$total_sponsor = $this->dashboard_model->getCount('sponser');
		$arrData['total_sponsor'] = $total_sponsor[0]['cnt'];



		 $where = "object_type IN ('A','E','S','event','O')";
        $arrProfileView = $this->notification_model->getAll($where);
		//echo $this->db->last_query();
        $saveAttendee = 0;
        $saveExhibitor = 0;
        $saveSpeaker = 0;

        $sharedAttendee = 0;
        $sharedExhibitor = 0;
        $sharedSpeaker = 0;
        $sharedEvent = 0;

        $messages = 0;
        $broadcasts = 0;
        $communication_meeting = 0;
        $communication_feedback = 0;
        $communication_notification = 0;
        $alert = 0;
		//echo '<pre>';print_r($arrProfileView);exit;
        foreach ($arrProfileView as $profile) {
            if ($profile['subject_type'] == 'A' && $profile['type'] == 'Sav')
                $saveAttendee++;
            if ($profile['subject_type'] == 'E' && $profile['type'] == 'Sav')
                $saveExhibitor++;
            if ($profile['subject_type'] == 'S' && $profile['type'] == 'Sav')
                $saveSpeaker++;

           // if ($profile['subject_type'] == 'Event' && $profile['type'] == 'Sh')
             //   $sharedEvent++;
            if ($profile['subject_type'] == 'A' && $profile['type'] == 'Sh')
                $sharedAttendee++;
            if ($profile['subject_type'] == 'E' && $profile['type'] == 'Sh')
                $sharedExhibitor++;
            if ($profile['subject_type'] == 'S' && $profile['type'] == 'Sh')
                $sharedSpeaker++;



            if ($profile['type'] == 'Msg' && $profile['subject_type'] != '0')
                $messages++;

            if ($profile['type'] == 'Msg' && $profile['subject_type'] == '0')
                $broadcasts++;

            if ($profile['type'] == 'Mtg')
                $communication_meeting++;

            if ($profile['type'] == 'A')
                $alert++;

            if ($profile['type'] == 'F')
                $communication_feedback++;

            if ($profile['type'] == 'N')
                $communication_notification++;
        }
        $arrData['communication_notification'] = $communication_notification;
        $arrData['communication_feedback'] = $communication_feedback;
        $arrData['alert'] = $alert;
        $arrData['broadcasts'] = $broadcasts;
        $arrData['communication_meeting'] = $communication_meeting;
        $arrData['messages'] = $messages;


        $arrData['saveAttendee'] = $saveAttendee;
        $arrData['saveExhibitor'] = $saveExhibitor;
        $arrData['saveSpeaker'] = $saveSpeaker;

        $arrData['sharedAttendee'] = $sharedAttendee;
        $arrData['sharedExhibitor'] = $sharedExhibitor;
        $arrData['sharedSpeaker'] = $sharedSpeaker;
        $arrData['sharedEvent'] = $sharedEvent;

		$arrResult = $this->dashboard_model->getAll();
		$arrExhId = array();
		$arrSpkId = array();
		$arrAtId = array();
		$download_evt_map = 0;
		$download_ses_pros = 0;
		$download_spe_pro = 0;
		$download_exh_pro = 0;
		$event_visit = 0;


		foreach ($arrResult as $res) {
			if ($res['subject_type'] == 'A' && $res['type'] == 'view')
				array_push($arrAtId, $res['subject_id']);
			if ($res['subject_type'] == 'S' && $res['type'] == 'view')
				array_push($arrSpkId, $res['subject_id']);
			if ($res['subject_type'] == 'E' && $res['type'] == 'view')
				array_push($arrExhId, $res['subject_id']);

			if ($res['subject_type'] == 'Event' && $res['type'] == 'view')
				$event_visit++;

			if ($res['type'] == 'download_evt_map')
				$download_evt_map++;
			if ($res['type'] == 'download_ses_map')
				$download_ses_pros++;
			if ($res['type'] == 'download_spe_map')
				$download_spe_pro++;
			if ($res['type'] == 'download_exe_map')
				$download_exh_pro++;
		}
			
		$arrData['arr_exh_view'] = $arr_exh_view = count(array_unique($arrExhId));
        $arrData['arr_att_view'] = $arr_att_view = count(array_unique($arrAtId));
        $arrData['arr_spk_view'] = $arr_att_view = count(array_unique($arrSpkId));

        $arrData['download_evt_map'] = $download_evt_map;
        $arrData['download_ses_pros'] = $download_ses_pros;
        $arrData['download_spe_pro'] = $download_spe_pro;
        $arrData['download_exh_pro'] = $download_exh_pro;
			   
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Analytics';
        $arrData['breadcrumb_tag'] = ' View all the event analytics here';
        $arrData['breadcrumb_class'] = 'fa-bar-chart-o';
        $arrData['middle'] = 'admin/dashboard';
        $this->load->view('admin/default', $arrData);

		}else{
			            redirect ('manage/index/dashboard');
		}
        
    }

	public function exdashboard(){
        $user_id = $this->session->userdata('user_id');


	    $arr_sponsor = $this->sponsor_model->getAll();
        $arrData['total_sponsor'] = $total_sponsor = count($arr_sponsor);

        $arr_exhibitors = $this->exhibitor_model->getAll($this->event_id, false, null, array(), 'exhibitor.event_id');
        $arrData['total_exhibitors'] = $total_exhibitors = count($arr_exhibitors);

		$where = "subject_type = 'Sp' AND analytics.event_id = {$this->event_id} AND analytics.type = 'Spl_hit'";
		$arr_splash_ad = $this->sponsor_model->get_sponsor_analytics($where);

		$where = "subject_type = 'Sp' AND analytics.event_id = {$this->event_id} AND analytics.type = 'Spo_hit'";
		$arr_spo_ad = $this->sponsor_model->get_sponsor_analytics($where);
		$arrData['arr_splash_ad'] = $arr_splash_ad;
		$arrData['arr_spo_ad'] = $arr_spo_ad;
		
	

        $featured = 0;
        foreach ($arr_exhibitors as $exh) {
            if ($exh['is_featured'] == 1)
                $featured++;
        }
        $arrData['featured_exhibtior'] = $featured;
        $arr_attendees = $this->attendee_model->getAll($this->event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');

        $arrData['total_attendees'] = $total_attendees = count($arr_attendees);

        $arr_speakers = $this->speaker_model->getAll($this->event_id, false, null, array(), 'LIKE', 'event_has_attendee.event_id');
        $arrData['total_speakers'] = $total_speakers = count($arr_speakers);


		$obj_msg_sent = $this->dashboard_model->getNotInfo();
		$arrData['msg_sent'] = $obj_msg_sent->cnt;
		
		$obj_msg_rcv = $this->dashboard_model->getNotInfo('subject');
		$arrData['msg_rcv'] = $obj_msg_rcv->cnt;
		
		$obj_meet_sent = $this->dashboard_model->getNotInfo('object','Mtg');
		$arrData['meet_sent'] = $obj_meet_sent->cnt;
		
		$obj_meet_rcv = $this->dashboard_model->getNotInfo('subject','Mtg');
		$arrData['meet_rcv'] = $obj_meet_rcv->cnt;
		
		$obj_not = $this->dashboard_model->getNotInfo('object','N');
		$arrData['not'] = $obj_not->cnt;
		

		
        $arr_where = array("event_id" => $this->event_id);
        $arrResult = $this->dashboard_model->getAll($arr_where);
		$event_visit = 0;

		foreach ($arrResult as $res) {
			  if ($res['subject_type'] == 'Event' && $res['type'] == 'view')
                $event_visit++;

		}

		 $arrAttendee = $this->dashboard_model->getAttendee();
        $attendeeApp = 0;
        foreach ($arrAttendee as $eachAttendee) {
            if ($eachAttendee['status'] == 1)
                $attendeeApp++;
        }
        $registerAttendee = count($arrAttendee);
		
        $arrData['event_visit'] = $event_visit;
        $arrData['attendeeApp'] = $attendeeApp;
        $arrData['registerAttendee'] = $registerAttendee;



		 $where = "object_type IN ('A','E','S','event','O')";
        $arrProfileView = $this->notification_model->getAll($where);
		//echo $this->db->last_query();
        $saveExhibitor = 0;
        $saveCurrentExhibitor = 0;
       
        $sharedExhibitor = 0;
        $sharedCurrentExhibitor = 0;
      
		$alert = 0;
		//echo '<pre>';print_r($arrProfileView);exit;
        foreach ($arrProfileView as $profile) {
           
            if ($profile['subject_type'] == 'E' && $profile['type'] == 'Sav')
                $saveExhibitor++;
           
		    if ($profile['subject_type'] == 'E' && $profile['subject_id'] == $user_id && $profile['type'] == 'Sav')
                $saveCurrentExhibitor++;
           
		    if ($profile['subject_type'] == 'E' && $profile['type'] == 'Sh')
                $sharedExhibitor++;
			
		    if ($profile['subject_type'] == 'E'  && $profile['subject_id'] == $user_id  && $profile['type'] == 'Sh')
                $sharedCurrentExhibitor++;
           


        }
        $arrData['saveExhibitor'] = $saveExhibitor;
        $arrData['saveCurrentExhibitor'] = $saveCurrentExhibitor;
     
		$arrData['sharedExhibitor'] = $sharedExhibitor;
		$arrData['sharedCurrentExhibitor'] = $sharedCurrentExhibitor;
     
		$arrResult = $this->dashboard_model->getAll();
		$arrExhId = array();
		$arrCurrentExhId = array();
		$arrSpkId = array();
		$arrAtId = array();
		$download_evt_map = 0;
		$download_ses_pros = 0;
		$download_spe_pro = 0;
		$download_exh_pro = 0;
		$download_exh_pro_curr = 0;

		$event_visit = 0;
		
		foreach ($arrResult as $res) {
			if ($res['subject_type'] == 'E' && $res['type'] == 'view')
				array_push($arrExhId, $res['subject_id']);

			if ($res['subject_type'] == 'E' && $res['type'] == 'view' && $res['subject_id'] == $user_id)
				array_push($arrCurrentExhId, $res['subject_id']);
			

			if ($res['subject_type'] == 'Event' && $res['type'] == 'view')
				$event_visit++;
			
			if ($res['type'] == 'download_exe_map')
				$download_exh_pro++;

			if ($res['type'] == 'download_exe_map' && $res['subject_id'] == $user_id)
				$download_exh_pro_curr++;

		}
			
		$arrData['arr_exh_view'] = $arr_exh_view = count(array_unique($arrExhId));
		$arrData['arr_exh_current_view'] = $arr_exh_view = count(array_unique($arrCurrentExhId));
    
        $arrData['download_exh_pro_curr'] = $download_exh_pro_curr;
        $arrData['download_exh_pro'] = $download_exh_pro;



		 $meetings = $this->dashboard_model->getMeetingExh();

        $no_of_meetings = count($meetings);
        $confirmed = 0;
        $declined = 0;
        $no_response = 0;
        if ($no_of_meetings != 0) {
            foreach ($meetings as $meet) {
                if ($meet['approve'] == 0)
                    $no_response++;

                if ($meet['approve'] == 1)
                    $confirmed++;

                if ($meet['approve'] == 2)
                    $declined++;
            }
        }
        $arrData['no_of_meetings'] = $no_of_meetings;
        $arrData['confirmed'] = $confirmed;
        $arrData['declined'] = $declined;
        $arrData['no_response'] = $no_response;



        $tou = 'A';
        $tos = 'industry';
        if ($this->input->post('type_of_user')) {
            $tou = $this->input->post('type_of_user');
        }
        if ($this->input->post('type_of_stat')) {
            $tos = $this->input->post('type_of_stat');
        }

        if ($tou == 'A')
            $arrData['interests'] = $arrInterest = $this->dashboard_model->getAttendeeInterest($tos);

        if ($tou == 'E')
            $arrData['interests'] = $arrInterest = $this->dashboard_model->getExhibitorInterest($tos);
//        echo $this->db->last_query();exit;
        if ($tou == 'S')
            $arrData['interests'] = $arrInterest = $this->dashboard_model->getAttendeeInterest($tos, 'speaker');
        $arrData['tos'] = $tos;
        $arrData['tou'] = $tou;


		$arrData['sessions'] = $arrSession = $this->dashboard_model->getSession();

		$arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Analytics';
        $arrData['breadcrumb_tag'] = ' View all the event analytics here';
        $arrData['breadcrumb_class'] = 'fa-bar-chart-o';
//        echo '<pre>';
//        print_r($arrData);//die;
        $this->load->view('admin/analytics_ex', $arrData);
	
	}

}

/* End of file index.php */
/* Location: ./application/controllers/admin/welcome.php */