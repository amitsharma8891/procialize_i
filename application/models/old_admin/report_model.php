<?php

class report_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
    }

    public $status = array("1","0");
    public $order_by = 'ASC';
    //public $order_name = 'tag.id';
    public $attendee_type = NULL;
    public $limit = '';
    public $offset = '';
    public $event_id = '';
    
    

   function get_organizer_event($organizer_id)
   {
       $query = $this->db
               -> select('*')
               -> from('event')
               -> where('organizer_id',$organizer_id)
               -> get();
       return $query->result_array();
               
   }

   function getAllAttendee($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $type = 'LIKE', $where = 'attendee.id') {

        if (!is_null($id))
            $this->db->where($where, $id);
        // $this->db->order_by($this->order_name, $this->order_by); //aatish code
        if ($search == 'NULL') {
            $this->db->order_by('attendee.created_date', 'desc');
        } else {
            //$this->db->order_by($this->order_name, $this->order_by);
        }
        if (!is_null($id) && $where == 'attendee.id')
            $this->db->select('(select group_concat(attendee_has_industry.industry_id) from attendee_has_industry where attendee_id = ' . $id . ') as industry_id   
        ,(select group_concat(attendee_has_functionality.functionality_id) from attendee_has_functionality where attendee_id = ' . $id . ') as functionality_id,   
        ', false);
        $this->db->select('attendee.id as attendee_id,user.id as user_id,attendee.*,user.*');
        $this->db->select('
            (select group_concat(attendee_has_industry.industry_id) from attendee_has_industry where attendee_id = event_has_attendee.attendee_id) as industry_id   
        ,(select group_concat(attendee_has_functionality.functionality_id) from attendee_has_functionality where attendee_id = attendee.id) as functionality_id,   
        ');
        $this->db->select('event.name as event_name,organizer.id as organizer_id,organizer.name as organizer_name,event.id as event_id,event_has_attendee.passcode,event_has_attendee.status as attendee_status');
        $this->db->select('event.event_start ,event.event_end ,event_profile.location as event_location,event_profile.city as event_city, event_profile.country as event_country');

        $this->db->join('user', 'user.id = attendee.user_id', 'left');
        $this->db->join('event_has_attendee', 'event_has_attendee.attendee_id = attendee.id');
        $this->db->join('event', 'event_has_attendee.event_id = event.id', 'left');
        $this->db->join('event_profile', 'event_profile.event_id = event.id', 'left');
        $this->db->join('organizer', 'organizer.id = event.organizer_id', 'left');
        /*if (!is_null($this->limit))
            $this->db->limit($this->limit, $this->offset);*/

        $this->db->where_in('attendee_type', $this->attendee_type);

        $superadmin = $this->session->userdata('is_superadmin');
        if (!$superadmin)
            $this->db->where('event.id', $this->event_id);

        $this->db->group_by('attendee_id');
        if ($row) {
            $result = $this->db->get('attendee')->row();

            return $result;
        } else {
            $result = $this->db->get('attendee');
            return $result->result_array();
        }
    }

   
   function notification_user($type,$event_id)
   {
        if($type == 'broadcasts')
        {
            $this->db->where('N_U.subject_id = 0 and N_U.subject_type = 0');
            $this->db->where('N_U.type',"Msg");
        }
        elseif($type == 'F')
        {
            $this->db->select('E_F_T.star,E_F_T.total');
            $this->db->where('N_U.type',$type);
            $this->db->join('event_feedback as E_F_T','E_F_T.id = N_U.feedback_id');
        }
        elseif($type == 'Mtg')
        {
            $this->db->select('M_T.approve');
            $this->db->where('N_U.type',$type);
            $this->db->join('meeting as M_T','M_T.id = N_U.meeting_id');
        }
        else
        {
            $this->db->where('N_U.type',$type);
        }
        
        if($this->attendee_type)
        {
            $this->db->where('N_U.subject_type',$this->attendee_type);
        }
           
       $query = $this->db
               -> select('S_A_T.id as sender_id,S_A_T.attendee_type as sender_type,S_A_T.name as sender_name,S_U_T.company_name as sender_company,S_U_T.designation as sender_designation,
                          R_A_T.id as receiver_id,R_A_T.attendee_type as receiver_type,R_A_T.name as receiver_name,R_U_T.company_name as receiver_company,R_U_T.designation as receiver_designation,
                          N_U.content,N_U.created_date
                         ')
               -> from ('notification_user as N_U')
               -> join('attendee as S_A_T','S_A_T.id = N_U.object_id ')
               -> join('user as S_U_T','S_U_T.id = S_A_T.user_id')
               -> join('attendee as R_A_T','R_A_T.id = N_U.subject_id ','left')
               -> join('user as R_U_T','R_U_T.id = R_A_T.user_id','left')
               //-> where('N_U.type',$type)
               -> where('N_U.event_id',$event_id)
               -> get();
       return $query->result_array();
               
   }
   
   function get_analytics($type,$event_id)
   {
       $this->db->where('A_T.subject_type',$type);
       $this->db->where('A_T.type','view');
       $this->db->group_by('A_T.subject_id');
       
       $query = $this->db
               -> select('S_A_T.id as sender_id,S_A_T.attendee_type as sender_type,S_A_T.name as sender_name,S_U_T.company_name as sender_company,S_U_T.designation as sender_designation,
                          R_A_T.id as receiver_id,R_A_T.attendee_type as receiver_type,R_A_T.name as receiver_name,R_U_T.company_name as receiver_company,R_U_T.designation as receiver_designation,
                          A_T.created_date
                         ')
               -> from ('analytics as A_T')
               -> join('attendee as S_A_T','S_A_T.id = A_T.object_id ')
               -> join('user as S_U_T','S_U_T.id = S_A_T.user_id')
               -> join('attendee as R_A_T','R_A_T.id = A_T.subject_id ','left')
               -> join('user as R_U_T','R_U_T.id = R_A_T.user_id','left')
               //-> where('N_U.type',$type)
               -> where('A_T.event_id',$event_id)
               -> get();
       return $query->result_array();
   }
   
   function get_user($type = '',$event_id)
   {
       if($type == 'app_used_by_user')
       {
           $this->db->where("(U_T.gcm_reg_id <> '')");
       }
       
       $query = $this->db
                -> select()
                -> from('event_has_attendee as E_A')
                -> join('attendee as A_T','A_T.id = E_A.attendee_id')
                -> join('user as U_T','U_T.id = A_T.user_id')
                -> where('E_A.event_id',$event_id)->get();
        return $query->result_array();
               
   }
   
   function get_session($event_id)
   {
       //$this->db-> select('(SELECT COUNT(*) FROM session_has_attendee  WHERE session_has_attendee.event_id = ' . $event_id . ') AS attendee_count ');
       $query = $this->db
                -> select('S_T.id as session_id,S_T.name,S_T.star as rating,S_T.total as user_count,
                           (SELECT COUNT(*) FROM session_has_attendee  WHERE session_has_attendee.session_id = S_T.id) AS attendee_count, 
                           (SELECT COUNT(*) FROM session_has_speaker  WHERE session_has_speaker.session_id = S_T.id) AS speaker_count ,
                           (SELECT COUNT(*) FROM session_question  WHERE session_question.session_id = S_T.id) AS question_count 
                        ')
                -> from ('session as S_T')
                -> where('S_T.event_id',$event_id)
                -> get();
       
        return $query-> result_array();
                //-> join ('session_has_question as S_Q','S_Q.session_id = S_T.id','LEFT')
                //-> join ('session_has_question as S_Q','S_Q.session_id = S_T.id','LEFT')
   }

}

?>
