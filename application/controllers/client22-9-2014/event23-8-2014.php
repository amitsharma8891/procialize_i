<?php

class Event extends CI_Controller {

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
        $this->load->model('client/client_event_model','model');
        $this->load->model('client/client_notification_model');
        $this->load->model('client/client_login_model');
        $this->load->helper('emailer_helper');
        
    }

    function event_list()
    {
        $this->session->set_userdata(array('client_event_id'=> ''));
        $search                                                                 = NULL;
        $json                                                                   = mysql_real_escape_string($this->uri->segment(2));
        if(isset($_GET['search']))
        {
            $this->model->search                                                = mysql_real_escape_string ($this->input->get('search_event',TRUE));
            $this->model->from                                                  = mysql_real_escape_string ($this->input->get('from',TRUE));
            $this->model->to                                                    = mysql_real_escape_string ($this->input->get('to',TRUE));
            $this->model->indsutry                                              = mysql_real_escape_string ($this->input->get('industry',TRUE));
            $this->model->functionality                                         = mysql_real_escape_string ($this->input->get('functionality',TRUE));
            $this->model->location                                              = mysql_real_escape_string ($this->input->get('location',TRUE));
        }
            
        if(isset($_GET['term']))
            $this->model->search                                                = mysql_real_escape_string(urldecode($this->input->get('term',TRUE)));
        $data                                                                   = array();
        $data                                                                   = $this->get_data(NULL,NULL,$search);
        
        if(isset($json) && $json != NULL)
        {
            if($json == 'json' )
            {
                echo json_encode($data);exit;
            }
            else
                exit;
        }
        //display($data);exit;
        //$this->session->set_userdata(array('client_event_passcode'=>''));
        $this->load->view(CLIENT_EVENT_LIST_VIEW,$data);
    }
    
    function get_data($event_id,$single_row,$search)
    {
        $data                                                                   = $this->model->getAll($event_id,$single_row,$search);
        return $data;
    }
    
    function event_detail()
    {
        //display($this->session->all_userdata());
        $event_id                                                               = $this->uri->segment(3);
        $json                                                                   = $this->uri->segment(4);
        $data                                                                   = array();
        if(is_numeric($event_id))
        {
        
            $this->model->event_id                                              = $event_id;
            $data                                                               = $this->model->getCount();
            $data['event_detail']                                               = $this->model->getAll($event_id,TRUE,NULL);
            if($data['event_detail']['event_list'])
            {
                $data['event_id']                                               = $event_id;
                
                $data['event']                                                  = $data['event_detail']['event_list'][0];
                $this->session->set_userdata(array('client_event_id'=>$event_id,'client_event_name'=>$data['event']['event_name'],'client_event_twitter_hastag'=>$data['event']['twitter']));
                $data['target_user_type']                                       = 'Event';
                $data['target_user_id']                                         = $event_id;
                $data['analytic_type']                                          = 'view';
                $data['common_location']                                        = array();
                $data['common_industry']                                        = array();
                if($data['event']['attendee_list'])
                {
                    foreach($data['event']['attendee_list'] as $key => $value)
                    {
                        $pos                                                    = @strpos(strtolower($value['attendee_city']), strtolower($this->session->userdata('client_user_city')));
                        if ($pos !== false && ($this->session->userdata('client_attendee_id') != $value['attendee_id'])) 
                        {
                            $data['common_location'][]                          = $value;
                        }
                        
                        $pos2                                                   = @strpos(strtolower($value['attendee_industry']), strtolower($this->session->userdata('client_user_industry')));
                        if ($pos2 !== false && ($this->session->userdata('client_attendee_id') != $value['attendee_id'])) 
                            $data['common_industry'][]                          = $value;
                    }
                }
                //display($data['common_industry']);exit;;
                //display($data['event']['attendee_list']);exit;
                if(isset($json) && $json != NULL)
                {
                    if($json == 'json' )
                    {
                        echo json_encode($data);exit;
                    }
                    else
                    {
                        exit;
                    }
                        
                }
                //display($this->session->all_userdata());
                if($this->session->userdata('client_user_id'))
                $this->load->view(CLIENT_EVENT_DETAIL_VIEW,$data);
                else
                    $this->load->view(CLIENT_LOGIN_VIEW,$data);
            }
            else
            {
                //echo 'Something Went wrong';
                $data['error_message']                                          = 'Event Not Found!';
                $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
            }
            
        }
        else
        {
            $data['error_message']                                              = 'Event Not Found!';
            $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
        }
    }
    
    function attendee_list()
    {
        if(!passcode_validatation())
            redirect(SITE_URL.'events');
        
        $data                                                                   = array();
        $json                                                                   = $this->uri->segment(3);
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        
        if(is_numeric($event_id))
        {
            $this->model->attendee_type = 'A';
            $data['attendee_list']                                                 = $this->model->getAttendee(NULL,$event_id);
            if($data['attendee_list'])
            {
                $data['event_id']                                               = $event_id;
                
                
                if(isset($json) && $json != NULL)
                {
                    if($json == 'json' )
                    {
                        echo json_encode($data);exit;
                    }
                    else
                    {
                        exit;
                    }
                        
                }
                $this->load->view(CLIENT_EVENT_ATTENDEE_LIST_VIEW,$data);
            }
            else
            {
                echo 'Data Not Found!';
            }
        }
        else
        {
            echo 'invalid event id';
        }
    }
    
    function attendee_detail()
    {
        if(!passcode_validatation())
            redirect(SITE_URL.'events');
        
        $json                                                                   = $this->uri->segment(4);
        $attendee_id                                                            = $this->uri->segment(3);
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        if(is_numeric($event_id) && is_numeric($attendee_id))
        {
            $this->model->attendee_id                                           = $attendee_id;
            $this->model->attendee_type = 'A';
            $data['attendee_detail']                                            = $this->model->getAttendee($attendee_id,$event_id);
            if($data['attendee_detail'])
            {
                $data['event_id']                                               = $event_id;
                
                $data['attendee_detail']                                        = $data['attendee_detail'][0];
                $data['fb_share_data']                                          = $data['attendee_detail'];
                
                $data['target_user_name']                                       = $data['attendee_detail']['attendee_name'];
                $data['target_user_type']                                       = 'A';
                $data['target_user_id']                                         = $data['attendee_detail']['attendee_id'];
                $data['analytic_type']                                          = 'view';
                $data['attendee_session']                                       = $this->model->getAttendeeHasSession($attendee_id,$event_id);//$data['attendee_detail'][0];
                $data['attendee_previous_event']                                = $this->model->getPriviousEvents($attendee_id);//$data['attendee_detail'][0];
                $data['attendee_list']                                          = $this->model->getActiveAttendee($event_id);    
                $this->client_notification_model->activity_flag                 = TRUE;
                $data['activity']                                               = $this->client_notification_model->getSocialMessage($data['attendee_detail']['attendee_id'],$event_id);    
               // display($data['activity']);exit;
                if(isset($json) && $json != NULL)
                {
                    if($json == 'json' )
                    {
                        echo json_encode($data);exit;
                    }
                    else
                    {
                        exit;
                    }
                }
                $this->load->view(CLIENT_EVENT_ATTENDEE_DETAIL_VIEW,$data);
            }
            else
            {
                $data['error_message']                                          = 'Attendee Not Found!';
                $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
            }
        }
        else
        {
            $data['error_message']                                              = 'Attendee Not Found!';
            $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
        }
    }
    
    
    function exhibitor_list()
    {
        if(!passcode_validatation())
            redirect(SITE_URL.'events');
        
        $json                                                                   = $this->uri->segment(3);
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        if(is_numeric($event_id))
        {
            $data['exhibitor_list']                                             = $this->model->getExhibitor(NULL,$event_id);
            
            $data['event_id']                                                   = $event_id;
                
            if(isset($json) && $json != NULL)
            {
                if($json == 'json' )
                {
                    echo json_encode($data);exit;
                }
                else
                {
                    exit;
                }
            }
            $this->load->view(CLIENT_EVENT_EXHIBITOR_LIST_VIEW,$data);
        }
        else
        {
            echo 'invalid event id';
        }
    }
    
    function exhibitor_detail()
    {
        if(!passcode_validatation())
            redirect(SITE_URL.'events'); 
        
        $json                                                                   = $this->uri->segment(4);
        $exhibitor_id                                                           = $this->uri->segment(3);
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        if(is_numeric($exhibitor_id))
        {
            $this->model->exhibitor_id                                          = $exhibitor_id;    
            $data['exhibitor_detail']                                           = $this->model->getExhibitor($exhibitor_id,NULL);
            if($data['exhibitor_detail'])
            {
                $data['exhibitor_detail']                                       = $data['exhibitor_detail'][0];
                $data['fb_share_data']                                          = $data['exhibitor_detail'];
                $data['event_id']                                               = $event_id;
                $data['target_user_name']                                       = $data['exhibitor_detail']['exhibitor_name'];
                $data['target_user_type']                                       = 'E';
                $data['target_user_id']                                         = $data['exhibitor_detail']['attendee_id'];
                $data['analytic_type']                                          = 'view';
                $this->client_notification_model->activity_flag                 = TRUE;
                $data['activity']                                               = $this->client_notification_model->getSocialMessage($data['exhibitor_detail']['attendee_id'],$event_id);    
                $this->client_notification_model->notification_type             = 'N';
                $this->client_notification_model->object_type                   = 'E';
                $this->client_notification_model->group_user_activity           = TRUE;
                $data['exhibitor_notification']                                 = $this->client_notification_model->getSocialMessage($data['exhibitor_detail']['attendee_id'],$event_id);    
                $this->client_notification_model->group_user_activity           = FALSE;
                //show_query();
                //display($data['exhibitor_notification']);
                if(isset($json) && $json != NULL)
                {
                    if($json == 'json' )
                    {
                        echo json_encode($data);exit;
                    }
                    else
                    {
                        exit;
                    }
                }
                //display($data);exit;
                if($data['exhibitor_detail'])
                $this->load->view(CLIENT_EVENT_EXHIBITOR_DETAIL_VIEW,$data);
                else
                {
                    $data['error_message']                                              = 'Exhibitor Not Found!';
                    $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
                }
            }
        }
    }

    
    function speaker_list()
    {
        if(!$this->session->userdata('client_attendee_id'))
            redirect(SITE_URL.'events');
        $data                                                                   = array();
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        
        $data                                                                   = $this->model->getCount();
        $data['event_id']                                                       = $event_id;
        $this->model->attendee_type = 'S';
        $data['speaker_list']                                                   = $this->model->getAttendee(NULL,$event_id);
        //display($data);
        $this->load->view(CLIENT_EVENT_SPEAKER_LIST_VIEW,$data);
    }
    
    function speaker_detail()
    {
        if(!$this->session->userdata('client_attendee_id'))
            redirect(SITE_URL.'events');
        $data                                                                   = array();
        $url_speaker_id                                                         = $this->uri->segment(3);
        if(is_numeric($url_speaker_id))
        {
            $event_id = $this->model->event_id                                  = $this->session->userdata('client_event_id');
            $data                                                               = $this->model->getCount();
            $data['event_id']                                                   = $event_id;
            $this->model->attendee_type = 'S';
            $data['speaker_detail']                                             = $this->model->getAttendee($url_speaker_id,$event_id);
            //$data['previous_events']                                            = $this->model->getAll();
            if($data['speaker_detail'])
            {
                $data['speaker_detail']                                         = $data['speaker_detail'][0];
                $data['fb_share_data']                                          = $data['speaker_detail'];
                //echo $url_speaker_id;
                $data['target_user_name']                                       = $data['speaker_detail']['attendee_name'];
                $data['target_user_type']                                       = 'S';
                $data['analytic_type']                                          = 'view';
                $data['target_user_id']                                         = $url_speaker_id;
                $data['speaker_session']                                        = $this->model->getSpeakerHasSession(NULL,$event_id,$url_speaker_id);
                $data['speaker_previous_event']                                 = $this->model->getPriviousEvents($url_speaker_id);
                $this->client_notification_model->activity_flag                 = TRUE;
                $data['activity']                                               = $this->client_notification_model->getSocialMessage($url_speaker_id,$event_id);    
                //display($data['speaker_previous_event']);
                $this->load->view(CLIENT_EVENT_SPEAKER_DETAIL_VIEW,$data);
            }
            else
            {
                $data['error_message']                                          = 'Speaker Not Found!';
                $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
            }
            
        }
        else
        {
            $data['error_message']                                          = 'Speaker Not Found!';
            $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
        }
        
    }
    
    function agenda()
    {
        if(!$this->session->userdata('client_attendee_id'))
            redirect(SITE_URL.'events');
        $data                                                                   = array();
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        $data['event_id']                                                       = $event_id;
        
        $data['agenda_list']                                                    = $this->model->getSession(NULL,$event_id);
        $this->load->view('client/event/client_event_agenda_list_view',$data);
    }
    
    function iframe_event_view()
    {
        $data                                                                   = array();
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        $data['event_id']                                                       = $event_id;
        
        $data['agenda_list']                                                    = $this->model->getSession(NULL,$event_id);
        //$data['agenda_view']                                                    = $this->load->view('client/event/client_event_agenda_view');
        //display($data);exit;
        $this->load->view('client/event/client_event_agenda_view',$data);
    }
    
    function session_detail()
    {
        $session_attendee_id                                                    = $this->session->userdata('client_event_attendee_id');
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        $data                                                                   = $this->model->getCount();
        $data['event_id']                                                       = $event_id;
        $url_session_id                                                         = $this->uri->segment(4);
        if(is_numeric($url_session_id))
        {
            $data['session_detail']                                             = $this->model->getSession($url_session_id,$event_id);
            if($data['session_detail'])
            {
                $data['session_detail']                                         = $data['session_detail'][0];
                $session_id = $this->model->session_id                          = $data['session_detail']['session_id'];
                $data['session_attendee']                                       = $this->model->getSessionAttendee($session_id,$session_attendee_id,$event_id);
                $data['session_speaker']                                        = $this->model->getSessionHasSpeaker($url_session_id,$event_id);    
                $data['session_question']                                       = $this->model->getSessionQuestion($url_session_id,$event_id);    
                //display($data['session_detail']);exit;
                $this->load->view(CLIENT_EVENT_SESSION_DETAIL_VIEW,$data);
            }
            else
            {
                $data['error_message']                                          = 'Session Not Found!';
                $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
            }
            
        }
        else
        {
            $data['error_message']                                              = 'Session Not Found!';
            $this->load->view(CLIENT_DATA_ERROR_VIEW,$data);
        }
        
        
    }
    
    
    function add_session_quetion()
    {
        $data                                                                   = array();
        
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something Went Wrong';
        $question                                                               = mysql_real_escape_string($this->input->post('question',TRUE));
        $session_id                                                             = mysql_real_escape_string($this->input->post('session',TRUE));
        $attendee_id                                                            = $this->session->userdata('client_attendee_id');
        if($question && $session_id && $attendee_id)
        {
            $table_array                                                        = array(
                                                                                        'session_id'            => $session_id,
                                                                                        'attendee_id'           => $attendee_id,
                                                                                        'question'              => $question,
                                                                                        'created_date'          => date('Y-m-d H:i:s'),
                                                                                        'pvt_org_id'            => 1,
                                                                                        );
            $this->db->insert('session_question',$table_array);
            
            if($this->db->insert_id())
            {
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = 'Question added successfull and will be answered by Speakers at the time of session';
            }
        }
        
        echo json_encode($json_array);
    }
    
    
    function send_message()
    {
        $event_id                                                               = $this->session->userdata('client_event_id');
        $attendee_id                                                            = $this->session->userdata('client_attendee_id');
        $message                                                                = mysql_real_escape_string($this->input->post('message_text',TRUE));
        $checkbox                                                               = $this->input->post('mesaage_checkbox');
        $target_attendee_id                                                     = $this->input->post('target_attendee_id');
        $target_user_type                                                       = $this->input->post('target_user_type');
        $mulitple_attendee_id                                                   = $this->input->post('mulitple_attendee');
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something Went Wrong';
        $get_organizer                                                          = $this->model->getOrganizer(NULL,$event_id);
           
        if($event_id && $attendee_id && $message && $get_organizer )
        {
            if($checkbox)
            {
                $message_id                                                     = $this->model->getMessageCounter($attendee_id,$target_attendee_id);
                $this->model->broadcast_msg                                     = TRUE;
                $send_msg                                                       = $this->model->send_mesage($attendee_id,md5($message_id->message_count),0,$target_user_type,$message,$event_id);
            }
            else
            {
                if($mulitple_attendee_id)
                {
                    $mulitple_attendee_id[]                                     = $target_attendee_id;
                    $this->model->multiple_msg                                  = TRUE;
                    foreach($mulitple_attendee_id as $k => $v)
                    {
                        
                        $message_id                                             = $this->model->getMessageCounter($attendee_id,$v);
                        $send_msg                                               = $this->model->send_mesage($attendee_id,md5($message_id->message_count),$v,$target_user_type,$message,$event_id);
                        
                        $get_target_attendee                                    = $this->client_login_model->getUserData($target_attendee_id);
                        $subject                                                = $get_organizer->event_name.' - Networking App by Procialize - '.$this->session->userdata('client_first_name').' has sent a message ';
                        $html                                                   = str_replace('{event_name}',$get_organizer->event_name,send_message_email_temp());
                        $html                                                   = str_replace('{subject_first_name}',  $get_target_attendee->first_name,$html);
                        $html                                                   = str_replace('{object_first_name}',  $this->session->userdata('client_first_name')  .','.  $this->session->userdata('client_user_company'),$html);
                        $html                                                   = str_replace('{msg_content}',  $message,$html);
                        $html                                                   = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);
                        
                        $to                                                     = $get_target_attendee->email;
                        if(check_DND($v))
                        sendMail($to, $subject, '',$html);
                    }
                }
                else
                {
                    $get_target_attendee                                        = $this->client_login_model->getUserData($target_attendee_id);
                    $subject                                                    = $get_organizer->event_name.' - Networking App by Procialize - '.$this->session->userdata('client_first_name').' has sent a message ';
                    $html                                                       = str_replace('{event_name}',$get_organizer->event_name,send_message_email_temp());
                    $html                                                       = str_replace('{subject_first_name}',  $get_target_attendee->first_name,$html);
                    $html                                                       = str_replace('{object_first_name}',  $this->session->userdata('client_first_name')  .','.  $this->session->userdata('client_user_company'),$html);
                    $html                                                       = str_replace('{msg_content}',  $message,$html);
                    $html                                                       = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);
                   
                    $to                                                         = $get_target_attendee->email;
                    
                    $message_id                                                 = $this->model->getMessageCounter($attendee_id,$target_attendee_id);
                    $this->model->single_msg                                    = TRUE;     
                    $send_msg                                                   = $this->model->send_mesage($attendee_id,md5($message_id->message_count),$target_attendee_id,$target_user_type,$message,$event_id);
                    if(check_DND($target_attendee_id))
                   sendMail($to, $subject, '',$html);
                }
                
            }
            if($send_msg)
            {
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = 'Message has been sent successfully!';
                
                //$this->db->update('message_counter',array('message_count' => $message_id->message_count+1));
            }
            
        }
        echo json_encode($json_array);
    }
    
    function message_counter($attendee_id,$target_attendee_id)
    {
        $message_id                                                             = $this->model->getMessageCounter($attendee_id,$target_attendee_id); //$this->db->insert_id();
            
        $message_id                                                             = $this->model->getMessageCounter($attendee_id,$target_attendee_id);
        
        return $message_id;
    }
    
    function reply_message()
    {
        
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something Went Wrong';
        $attendee_id                                                            = $this->session->userdata('client_attendee_id');
        $message                                                                = mysql_real_escape_string($this->input->post('message_text',TRUE));
        $target_attendee_id                                                     = $this->input->post('target_attendee_id');
        $message_id                                                             = $this->input->post('message_id');
        $event_id                                                               = $this->input->post('event_id');
        if($attendee_id && $message && $target_attendee_id && $message_id)
        {
            $send_msg                                                           = $this->model->send_mesage($attendee_id,$message_id,$target_attendee_id,"A",$message,$event_id);
            if($send_msg)
            {
                $json_array['error']                                                    = 'success';
                $json_array['msg']                                                      = 'Message Sent Successfully!';
            }
        }
        
        echo json_encode($json_array);
    }
    
    
    function search()
    {
        if(!isset($_GET['term']))
            exit;
        
        $this->model->search                                                    = mysql_real_escape_string(urldecode($this->input->get('term',TRUE)));
        $options                                                                = array();
        $json_array                                                             = array();
        $this->model->autocomplete                                              = TRUE;
        $data                                                                   = $this->model->getAll();//$this->get_data(NULL,NUll,$search);            
                             
        if($data['event_list'])
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
        }
        
        echo json_encode($json_array);
    }
    
    
    function search_user()
    {
        $user_type                                                              = $this->input->get('type',TRUE);
        $offset                                                                 = $this->input->get('offset',TRUE);
        $scroll                                                                 = $this->input->get('scroll',TRUE);
        $keyword                                                                = mysql_real_escape_string($this->input->get('term',TRUE));
        $json_array['user']                                                     = array();
        $json_array['search_flag']                                              = FALSE;
        $json_array['scroll_flag']                                              = $scroll;
        if($keyword)
            $json_array['search_flag']                                          = TRUE;
        $this->model->limit                                                     = PAGE_LIMIT;
        if($offset)
        $this->model->offset                                                    = (int)(PAGE_LIMIT*$offset);
        if($user_type)
        {
            $event_id                                                           = $this->session->userdata('client_event_id');
            if($user_type == 'attendee')
            {
                $this->model->search                                            = $keyword;
                
                $data                                                           = $this->model->getAttendee(NULL,$event_id);
                $json_array['user']                                             = $this->getAttendeeListHtml($data);    
            }
            elseif($user_type == 'exhibitor')
            {
                $this->model->search                                            = $keyword;
                $data                                                           = $this->model->getExhibitor(NULL,$event_id);
                $json_array['user']                                             = $this->getExhibitorListHtml($data);    
            }
            
            
            
        }
        echo json_encode($json_array);
    }
    
    function get_all_user()
    {
        $event_id                                                               = $this->session->userdata('client_event_id');
        $user_type                                                              = '';
        $json_array                                                             = array();            
        $this->model->search                                                    = mysql_real_escape_string($this->input->get('term',TRUE));
        $user_list                                                              = $this->model->getActiveAttendee($event_id);
        
        if($user_list)
        {
            foreach($user_list as $key => $value)
            {
                if($value['attendee_type'] == 'A')
                    $user_type = '(Attendee)';
                elseif($value['attendee_type'] == 'E')
                    $user_type = '(Exhibitor)';
                elseif($value['attendee_type'] == 'S')
                    $user_type = '(Speaker)';
                $json_array[]                                                   = array(
                                                                                        'id'                => $value['id'],
                                                                                        'label'             => strip_slashes($value['name']).$user_type,
                                                                                        'value'             => strip_slashes($value['name']).$user_type,
                                                                                    );
            }
        }
        echo json_encode($json_array);    
        
    }
    
    function getAttendeeListHtml($data)
    {
        $html                                                                   = '';
        if($data)
        {
            foreach($data as $key => $attendee)
            {
                $html                                                          .= '<div class="col-xs-12"><a href="'.SITE_URL.EVENT_CONTROLLER_PATH.'attendee-detail/'.$attendee['attendee_id'].'"><div class="stat well well-sm attnd"><div class="row">
                                                                                   <div class="col-xs-4"><div class="thumb"><img src="'.SITE_URL.'uploads/'.front_image('attendee',$attendee['attendee_image']).'" alt="" class="img-responsive userlogo"/>
                                                                                   </div></div><div class="col-xs-8 eventdet"><h4>'.$attendee['attendee_name'].'</h4><small class="stat-label">'.designation_company($attendee['attendee_designation'],$attendee['attendee_company']).'</small>
                                                                                   <small class="stat-label">'.industry_functionality($attendee['attendee_industry'],$attendee['attendee_functionality']).'</small><small class="stat-label">'.$attendee['attendee_city'].'</small></div>
                                                                                   </div><!-- row --></div><!-- stat --></a></div>'; 
            }
        }
        else
        {
            $html                                                              .= '<div class="col-xs-12">No Attendee Found</div>';
        }
        return $html;
    }
    
    function getExhibitorListHtml($data)
    {
        $html                                                                   = '';
        if($data)
        {
            foreach($data as $key => $value)
            {
                $html                                                          .= '<div class="col-sm-6 col-md-4"><div class="stat well well-sm"><a href="'.SITE_URL.'events/exhibitor-detail/'.$value['attendee_id'].'"><div class="row">
                                                                                   <div class="col-xs-4"><div class="thumb"><img src="'. SITE_URL.'uploads/'.front_image('exhibitor',$value['exhibitor_logo']).'" alt="" class="img-responsive userlogo"/></div></div>
                                                                                   <div class="col-xs-8 eventdet">';
                if($value['exhibitor_featured'] == 1) {	
                $html                                                          .= '<span class="pull-right mr10"><p class="featured_icon"><i class="fa fa-bookmark"></i></p></span>';
                }
                    
                $html                                                          .='<h4>'.ucwords(strtolower($value['exhibitor_name'])).'</h4><small class="stat-label">'.$value['exhibitor_city'].', '.$value['exhibitor_country'].'</small><small class="stat-label">'.$value['exhibitor_industry'].'</small>
                                                                                  <small class="stat-label">Stall Number: <strong>'.$value['stall_number'].'</strong></small></div></div><!-- row --></a>';
				
                    
                if($value['exhibitor_featured'] == 1) {
                $html                                                          .= '<hr><p class="exinfo"><strong>Email:</strong> '.$value['exhibitor_email'].'</p>';
                
                }
				
                $html                                                          .= '</div><!-- stat --></div>'; 
            }
        }
        return $html;
    }
            
    function user_login()
    {
        $email                                                                  = mysql_real_escape_string($this->input->post('email',TRUE));
        $password                                                               = mysql_real_escape_string($this->input->post('password',TRUE));
        $json_array['error']                                                    = 'error'; 
        $json_array['msg']                                                      = 'Invalid User!';
        if(!isset($email) || $email == '' || $password == ''  || !isset($password))
        {
            echo json_encode($json_array);exit;
        }
         
        $user_data                                                              = $this->model->getUser($email,$password);
        if($user_data)
        {
            $user_data                                                          = $user_data[0];
            if($user_data['status'] == 1)
            {
                
                $seesion_data                                                   = array(
                                                                                            'client_user_id'      => $user_data['user_id'],
                                                                                            'client_email'        => $user_data['email'],
                                                                                            'client_user_type'    => $user_data['type_of_user'],
                                                                                            'client_first_name'   => $user_data['first_name'],
                                                                                        );
                $this->session->set_userdata($seesion_data);
                $json_array['redirect']                                         = SITE_URL.'events';
                if($this->session->userdata('event_reffaral'))
                {
                    $json_array['redirect']                                     = $this->session->userdata('event_reffaral');
                }
                $json_array['error']                                            = 'success';
                
            }
            else
            {
                $json_array['error']                                            = 'error';
                $json_array['msg']                                              = 'User has been Blocked!';
            }
        }
        
        echo json_encode($json_array);
    }
    
    function logout()
    {
        $seesion_data                                                           = array(
                                                                                            'client_user_id'            => '',
                                                                                            'client_attendee_id'        => '',
                                                                                            'client_email'              => '',
                                                                                            'client_user_type'          => '',
                                                                                            'client_first_name'         => '',
                                                                                            'client_event_passcode'     => '',
                                                                                            'passcode_event_id'         => '',
                                                                                        );
        $this->session->unset_userdata($seesion_data);
        
        delete_cookie("email");
        delete_cookie("password");
        redirect(SITE_URL.'events');
    }
    
    function event_login()
    {
        $passcode                                                               = mysql_real_escape_string($this->input->post('passcode'));
        $event_id                                                               = $this->session->userdata('client_event_id');    
        $attendee_id                                                            = $this->session->userdata('client_attendee_id');    
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Invalid Passcode!';
        if($passcode && $event_id)
        {
            $check_passcode                                                     = $this->model->check_passcode($event_id,$attendee_id,$passcode);
            //display($check_passcode);
            if($check_passcode)
            {
                $session_array                                                  = array(
                                                                                        'client_event_passcode'         => $passcode,
                                                                                        'passcode_event_id'             => $event_id,
                                                                                        );    
                $this->session->set_userdata($session_array);
                $this->db->where('attendee_id',$attendee_id);
                $this->db->where('event_id',$event_id);
                $this->db->update('event_has_attendee',array('status'=>1));
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = 'Success';
            }
            
        }
        
        echo json_encode($json_array);
    }
    
    function session_rsvp()
    {
        $event_id                                                               = $this->session->userdata('client_event_id');
        $attendee_id                                                            = $this->session->userdata('client_attendee_id');
        $check_event_register                                                   = $this->model->check_passcode($event_id,$attendee_id);
        
        if(!$check_event_register)
        {
            $json_array['error']                                                = 'error';
            $json_array['msg']                                                  = 'Please first register to the Event';
             echo json_encode($json_array);
            exit;
        }
        
        $session_id                                                             = $this->input->post('session_id');
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something Went Wrong';
        $get_session                                                            = $this->model->getSession($session_id);
        $get_organizer                                                          = $this->model->getOrganizer(NULL,$event_id);
        if($session_id && is_numeric($session_id) && $get_organizer)
        {
            $json_array['error']                                                = 'success';
            $json_array['msg']                                                  = 'RSVP Successfully!';
            $rsvp                                                               = $this->model->do_rsvp($session_id,$attendee_id);
            
            $to                                                                 = $get_organizer->email;//$this->session->userdata('client_email');
            $subject                                                            = 'Procialize: Registration request for session';
            $subject                                                            = $get_organizer->event_name.' - Networking App by Procialize - '.$this->session->userdata('client_first_name').' has registered for Session '.@$get_session[0]['session_name'];
            $html                                                               = str_replace('{session_name}',@$get_session[0]['session_name'],mail_to_organizer_when_attendee_rsvp());
            $html                                                               = str_replace('{org_name}',$get_organizer->organizer_name,$html);
            $html                                                               = str_replace('{first_name}',  $this->session->userdata('client_first_name'),$html);
            $html                                                               = str_replace('{email}',  $this->session->userdata('client_email'),$html);
            $html                                                               = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);
                
                
            sendMail($to, $subject, '',$html);
            
        }
        
        
        echo json_encode($json_array);
    }
    
    function event_registration()
    {
        $event_id                                                               = $this->session->userdata('client_event_id');
        $user_id                                                                = $this->session->userdata('client_user_id');
        $attendee_id                                                            = $this->session->userdata('client_attendee_id');
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something Went Wrong!';
        if($event_id && $user_id)
        {
            //echo '269';
            $check_attendee                                                     = $this->model->checkAttendee($event_id,$attendee_id);
            $user_data                                                          = $this->model->getUser(NULL,NULL,$user_id,$status=1);
                        
            if($check_attendee )
            {
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = 'You have already registered for this event, check your mail regularly. You will receive the event Passcode from Procialize Admin team.';
            }
                
            $get_organizer                                                      = $this->model->getOrganizer(NULL,$event_id);
            if(!$check_attendee &&  $get_organizer)
            {
                $user_data                                                      = $user_data[0];
                $save_attendee                                                  = $this->model->insert_attendee($attendee_id,$event_id);
                
                $to                                                             = $get_organizer->email;//$this->session->userdata('client_email');
                
                $subject                                                        =   'Procialize: Registration request for session';
                $subject                                                        = $get_organizer->event_name.' - Networking App by Procialize - Event registration request by '.$this->session->userdata('client_first_name') ;
                $html                                                           = str_replace('{event_name}',$get_organizer->event_name,mail_to_organizer_for_registration_request());
                $html                                                           = str_replace('{org_name}',$get_organizer->organizer_name,$html);
                $html                                                           = str_replace('{first_name}',  $this->session->userdata('client_first_name'),$html);
                $html                                                           = str_replace('{email}',  $this->session->userdata('client_email'),$html);
                $html                                                           = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);
                
                
                sendMail($to, $subject, '',$html);
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = 'Thank you. Your registration request has been sent to the organizer. You shall receive a mail along with Passcode from Procialize Admin soon.';
                //send the mail
            }
        }
        echo json_encode($json_array);
    }
    
    function setup_meeting()
    {
//        /echo 'test';
        $data                                                                   = array();
        $data                                                                   = array();
        $event_id = $this->model->event_id                                      = $this->session->userdata('client_event_id');
        
        $data                                                                   = $this->model->getCount();
        $data['target_attendee_id']                                             = $this->uri->segment(3);
        //$this->load->view(CLIENT_EVENT_SETUP_MEETING_VIEW,$data);
        
        $this->load->view('client/setup_meeting/client_user_setup_meeting_view',$data);
    }
    
    function setup_meeting_iframe()
    {
        $data                                                                   = array();
        $from_array                                                             = array();
        $to_array                                                               = array();
        $data['from_id']                                                        = $this->session->userdata('client_attendee_id'); 
        $data['to_id']                                                          = $this->uri->segment(4);
        $data['to_name']                                                        = $this->model->getName($data['to_id']);
        $event_id                                                               = $this->session->userdata('client_event_id');
        
        
        $data['agenda_list']                                                    = '';
        $data['event_date_list']                                                     = $this->model->getEventDate($event_id);
        
        $data['agenda_list']                                                    = $this->model->getRsvpSession($data['from_id'],$data['to_id'],$event_id);
        $data['meeting_list']                                                   = $this->model->getMeeting($data['from_id'],$data['to_id'],$event_id);
        //display($data['meeting_list']);
        $data['agenda_list'] = array_merge($data['agenda_list'], $data['meeting_list']);
        foreach($data['agenda_list'] as $key => $value)
        {
            if($data['from_id'] == $value['object_id'] || $data['from_id'] == @$value['subject_id'])
            {
                $from_array[$key]                                                   = $value;
                $from_array[$key]['track_id']                                       = 0;
                
            }
            
            if($data['to_id'] == $value['object_id'] || $data['to_id'] == @$value['subject_id'])
            {
                $to_array[$key]                                                     = $value;
                $to_array[$key]['track_id']                                                     = 1;
            }
                                                  
        }
        
        $data['agenda_list'] = array_merge($from_array, $to_array);
        //display($from_array);
        //display($to_array);
        //display($data['agenda_list']);
        $this->load->view('client/setup_meeting/client_user_iframe_meeting_view',$data);
    }
    
    function iframe_my_calender()
    {
        echo '<h1>My calender</h1>';
        $data                                                                   = array();
        $data['from_id']                                                        = $this->session->userdata('client_attendee_id');                                            
        $data['to_id']                                                          = $this->uri->segment(4);
        $data['calender_data']                                                  = $this->get_calender_data($data['from_id'],$data['to_id'],$flag = 'from');
        //display($data['calender_data']);
        $this->load->view(CLIENT_EVENT_MY_CALENDER_VIEW,$data);
    }
    
    function iframe_target_calender()
    {
        echo '<h1>Target Calender</h1>';
        $data                                                                   = array();
        $data['from_id']                                                        = $this->session->userdata('client_attendee_id');                                            
        $data['to_id']                                                          = $this->uri->segment(4);
        $data['calender_data']                                                  = $this->get_calender_data($data['from_id'],$data['to_id'],$flag = 'to');
        //display($data['calender_data']);
        $this->load->view(CLIENT_EVENT_TARGET_CALENDER_VIEW,$data);
    }
    
    function get_calender_data($from_id,$to_id,$flag)
    {
        $event_id                                                               = $this->session->userdata('client_event_id');
        if($from_id && $to_id)
        {
            
            if($flag == 'from')
            {
                $this->model->from_flag = 'from';
                $attendee_id                                                    = $from_id;
            }
            else
            {
                $this->model->to_flag = 'to';
                $attendee_id                                                    = $to_id;
            }
                
            
            $data['agenda_list']                                                = $this->model->getRsvpSession($attendee_id,$event_id);
            $data['meeting_list']                                               = $this->model->getMeeting($from_id,$to_id,$event_id);
            //display($data['meeting_list']);
            $result = array_merge($data['agenda_list'], $data['meeting_list']);
            
            return $result;
        }
    }
    
    function set_meeting()
    {
        $data['start_time']                                                     = date('Y-m-d H:i:s',strtotime($this->input->post('start')));
        $data['end_time']                                                       = date('Y-m-d H:i:s',strtotime($this->input->post('end')));
        $data['target_id']                                                      = $this->input->post('target_id');
        $data['target_type']                                                    = $this->input->post('target_type');
        $data['title']                                                          = $this->input->post('title');
        $data['attendee_id']                                                    = $this->session->userdata('client_attendee_id');
        $data['attendee_type']                                                  = $this->session->userdata('client_user_type');
        $data['event_id']                                                       = $this->session->userdata('client_event_id');
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something went Wrong!';
        $get_organizer                                                          = $this->model->getOrganizer(NULL,$data['event_id']);
        if($data['start_time'] && $data['end_time'] && $data['target_id'] && $data['title'])
        {
            $check_slot                                                         = $this->model->check_slot($data['attendee_id'],$data['start_time'],$data['end_time']);
            
            //display($check_slot);
            
            if($check_slot)
            {
                $json_array['error']                                            = 'error';
                $json_array['msg']                                              = 'This slot is not available.';
                echo json_encode($json_array);
                exit;
            }
            $set_meeting                                                        = $this->model->set_meeting($data);
            if($set_meeting)
            {
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = 'Meeting Set successfully! wating for approval';
                
                $get_target_attendee                                            = $this->client_login_model->getUserData($data['target_id']);
                $subject                                                        = $get_organizer->event_name.' - Networking App by Procialize - '.$this->session->userdata('client_first_name').' has requested for a meeting';
                $html                                                           = str_replace('{event_name}',$get_organizer->event_name,setup_meeting_email_temp());
                $html                                                           = str_replace('{meeting_date}',  date('d M Y',  strtotime($data['start_time'])),$html);
                $html                                                           = str_replace('{meeting_time}',  (date('h .i A',  strtotime($data['start_time'])) .'-'.date('h .i A',  strtotime($data['end_time']))),$html);
                $html                                                           = str_replace('{subject_first_name}',  $get_target_attendee->first_name,$html);
                $html                                                           = str_replace('{object_first_name}',  $this->session->userdata('client_first_name').','.$this->session->userdata('client_user_company'),$html);
                $html                                                           = str_replace('{msg_content}',  $data['title'],$html);
                $html                                                           = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);

                $to                                                             = $get_target_attendee->email;
                if(check_DND($data['target_id']))
                sendMail($to, $subject, '',$html);
                
            }
        }
        
        echo json_encode($json_array);
    }
    
    function reply_meeting()
    {
        $data['event_id']                                                       = $this->input->post('event_id');
        $data['meeting_id']                                                     = $this->input->post('meeting_id');
        $data['meeting_reply_text']                                             = $this->input->post('meeting_reply_text');
        $data['target_id']                                                      = $this->input->post('target_id');
        $data['target_type']                                                    = $this->input->post('target_type');	
        $data['responce']                                                       = $this->input->post('responce_type');
        $data['attendee_id']                                                    = $this->session->userdata('client_attendee_id');
        $data['attendee_type']                                                  = $this->session->userdata('client_user_type');
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something went Wrong!';
        $get_organizer                                                          = $this->model->getOrganizer(NULL,$data['event_id']);
        $get_meeting                                                            = $this->client_notification_model->getMeeting($data['meeting_id']);
        if($data['target_id'] && $data['meeting_id'] && $data['attendee_id'] && $data['responce'])
        {
            $reply_meeting                                                      = $this->model->reply_meeting($data);
            if($reply_meeting)
            {
                $json_array['error']                                            = 'success';
                $json_array['msg']                                              = $reply_meeting;
                $get_target_attendee                                            = $this->client_login_model->getUserData($data['target_id']);
                $subject                                                        = $get_organizer->event_name.' - Networking App by Procialize - '.$this->session->userdata('client_first_name').' has '.$data['responce'].'ed for a meeting';
                $html                                                           = str_replace('{event_name}',$get_organizer->event_name,reply_setup_meeting_email_temp());
                $html                                                           = str_replace('{meeting_date}',  date('d M Y',  strtotime($get_meeting->start_time)),$html);
                $html                                                           = str_replace('{meeting_time}',  (date('h .i A',  strtotime($get_meeting->start_time)).'-'.date('h .i A',  strtotime($get_meeting->end_time))),$html);
                $html                                                           = str_replace('{subject_first_name}',  $get_target_attendee->first_name,$html);
                $html                                                           = str_replace('{object_first_name}',  $this->session->userdata('client_first_name').','.$this->session->userdata('client_user_company'),$html);
                $html                                                           = str_replace('{responce}',  $data['responce'],$html);
                $html                                                           = str_replace('{msg_content}',  $get_meeting->message,$html);
                $html                                                           = str_replace('{IMAGE_PATH}',CLIENT_IMAGES,$html);

                $to                                                             = $get_target_attendee->email;
                if(check_DND($data['target_id']))
                sendMail($to, $subject, '',$html);
            }
        }
        
        echo json_encode($json_array);
    }
    
    
    
    
    
    
    
    function share_via_email()
    {
        $from_email                                                             = $this->session->userdata('client_email');           
        $from_email                                                             = $this->session->userdata('client_user_name');           
        $to_address                                                             = $this->input->post('send_to');
        $email_body                                                             = $this->input->post('send_message_text');
        $subject                                                                = 'This is share via email';
        
        if(check_DND())
        sendMail($to_address, $subject, '',$email_body);
    }
    
    function download()
    {
        $this->load->helper('download');
        $type                                                                   = $this->uri->segment(4);
        $subject_id                                                             = $this->uri->segment(5);
        $file_name                                                              = $this->uri->segment(6);
        if($type == 'S' )
        {
            $path   = 'speaker';
            $donload_name = 'Profile.pdf';
        }
        elseif($type == 'E' )
        {
            $path   = 'exhibitor/brochure';
            $donload_name = 'broture.pdf';
        }
        elseif($type == 'EVENT' )
        {
            $path   = 'events/floorplan';
            $donload_name = 'Event_map.pdf';
        }
        elseif($type == 'SESSION' )
        {
            $path   = 'session';
            $donload_name = 'Event_map.pdf';
        }
        
            
        $data = file_get_contents(SITE_URL."uploads/".$path."/".$file_name); // Read the file's contents
        $name = $file_name;
        push_analytics('download',$subject_id,ucwords(strtolower($type)));
        force_download($name, $data);
    }
    
    function mail_test()
    {
        $to = 'amit.sharma@infiniteit.biz';
        $subject = 'Test';
        $message = 'Test with new api key mandrill';
        sendMail($to, $subject, $message);

    }
}