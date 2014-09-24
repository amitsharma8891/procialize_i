<?php

class client_event_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();
       
    }
    public $limit                                                               = NULL;
    public $offset                                                              = 0;
    public $event_id                                                            = NULL;
    public $attendee_id                                                         = NULL;
    public $exhibitor_id                                                        = NULL;
    public $organizer_id                                                        = NULL;
    public $session_id                                                          = NULL;
    public $autocomplete                                                        = FALSE;
    public $user_id                                                             = NULL;
    public $search                                                              = NULL;
    public $from                                                                = NULL;
    public $to                                                                  = NULL;
    public $indsutry                                                            = NULL;
    public $functionality                                                       = NULL;
    public $location                                                            = NULL;
    public $previous_event_id                                                   = NULL;
    public $attendee_in_clause                                                  = array();
    public $speaker_in_clause                                                   = array();
    public $event_detail                                                        = FALSE;
    public $single_msg                                                          = FALSE;
    public $multiple_msg                                                        = FALSE;
    public $broadcast_msg                                                        = FALSE;
    public $from_flag                                                           = NULL;
    public $to_flag                                                             = NULL;
    public $attendee_type                                                       = NULL;
   
            

    /**
     * get
     *
     * gets Events
     * 
     * @author  AMIT SHARMA
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE,$search = NULL, $fields = array()) 
    {
        
        $event_query                                                            =  $this->db
                                                                                -> select(
                                                                                       'E_T.id as event_id,
                                                                                        E_T.name as event_name,
                                                                                        E_T.description as event_description,
                                                                                        E_T.is_featured as featured,
                                                                                        E_T.event_start,
                                                                                        E_T.event_end,
                                                                                        E_P.location as event_location,
                                                                                        E_P.city as event_city,
                                                                                        E_P.country as event_country,
                                                                                        E_P.latitude as event_latitude,
                                                                                        E_P.longitude as event_longitude,
                                                                                        E_P.website,
                                                                                        E_P.linkden,
                                                                                        E_P.twitter,
                                                                                        E_P.facebook,
                                                                                        E_P.logo as event_logo,
                                                                                        E_P.image1,
                                                                                        E_P.image2,
                                                                                        E_P.image3,
                                                                                        E_P.contact_name,
                                                                                        E_P.contact_email,
                                                                                        E_P.floor_plan,
                                                                                        E_T.organizer_id,
                                                                                        O_T.name as event_organizer,
                                                                                        O_T.organiser_photo ,
                                                                                        group_concat(DISTINCT I_T.name) as event_industry,
                                                                                        group_concat(DISTINCT F_T.name) as event_functionality,
                                                                                        '
                                                                                        )
                                                                                -> from('event as E_T')
                                                                                -> join('event_profile as E_P','E_P.event_id = E_T.id')
                                                                                -> join('event_has_industry as E_I','E_I.event_id = E_T.id','LEFT')
                                                                                -> join('organizer as O_T','O_T.id = E_T.organizer_id','LEFT')
                                                                                -> join('industry as I_T','I_T.id = E_I.industry_id')
                                                                                -> join('event_has_functionality as E_F','E_F.event_id = E_T.id','LEFT')
                                                                                -> join('functionality as F_T','F_T.id = E_F.functionality_id')
                                                                                
                                                                                -> group_by('E_I.event_id')
                                                                                -> group_by('E_F.event_id')
                                                                                
                                                                                -> where('E_T.status',1)
                                                                                -> order_by('E_T.is_featured','DESC')
                                                                                -> limit(10); 
        if($this->search || $this->from || $this->to || $this->indsutry || $this->functionality || $this->location)
        {
            $search                                                             = $this->search;
            $this->db->join('tag_relation as T_R','T_R.object_id = E_T.id','LEFT');
            $this->db->join('tag as T_T','T_T.id = T_R.tag_id','LEFT');
            $this->db->group_by('T_R.object_id');
            
            if($this->from && $this->to)
            {
                $from                                                           = date('Y-m-d',strtotime(($this->from))).'<br>';
                $to                                                             = date('Y-m-d',strtotime(($this->to)));
                $this->db->where('(DATE(E_T.event_start) >= "'.$from.'" AND DATE(E_T.event_end) <= "'.$to.'")');
            }
            
            
            
            if($this->indsutry)
                $this->db->where("I_T.name ",$this->indsutry);
            
            if($this->functionality)
                $this->db->where("F_T.name",$this->functionality);
            
            if($this->location)
                $this->db->where("(E_P.city LIKE '$this->location%' || E_P.country LIKE '$this->location%')");
            
            $temp                                                               = explode(',',$search);
            foreach($temp as $k => $v)
            {
                $search                                                         = $v;
                if($search)
                $this->db->where("(E_T.name LIKE '$search%'|| E_T.description LIKE '%$search%' || E_P.city LIKE '$search%' || E_P.country LIKE '$search%' || I_T.name LIKE '$search%' || F_T.name LIKE '$search%' || T_T.tag_name LIKE '$search%' || O_T.name LIKE '$search%')");
            }
        }
        
        if($this->attendee_in_clause)
        {
            $this->db->where('E_T.id IN ('.implode(',',$this->attendee_in_clause).')');
        }
            
        
        if($id)
            $this->db->where('E_T.id',$id);
        
        if(!is_null($this->limit))
                 $this->db->limit($this->limit, $this->offset);
        
        $query_result                                                           = $this->db->get();
            //echo $this->db->last_query();
        $result['event_list'] = $query_result->result_array();
        
        if($this->autocomplete || $this->event_detail)
            return $result;
        
            
        if($result['event_list'] )
        {
            foreach ($result['event_list'] as $key=> $value)
            {
                $this->attendee_type                                            = 'A';    
                $result['event_list'][$key]['attendee_list']                    = $this->getAttendee($this->attendee_id,$value['event_id']); //$attendee_query->result_array();

                //$result['event_list'][$key]['exhibitor_list']                   = $this->getExhibitor($this->exhibitor_id,$value['event_id']); //$exhibitor_query->result_array();                
 
                //$result['event_list'][$key]['session_list']                     = $this->getSession(NULL,$value['event_id']);  //$session_query->result_array(); 
                $this->event_id                                                 = $value['event_id'];
                $result['event_list'][$key]['count']                            = $this->getCount();
            }

        }

        //display($result);exit;
        return $result;
    }
    
    function getAttendee($attendee_id=NULL,$event_id,$user_id=NULL)
    {
        $this->db->where('A_T.mail_sent',1);
        $attendee_query                                                         =  $this->db
                                                                                -> select(
                                                                                        '
                                                                                         E_A.attendee_id as attendee_id,
                                                                                         (select group_concat(industry.name) from attendee_has_industry INNER JOIN industry ON industry.id = attendee_has_industry.industry_id  where attendee_id = E_A.attendee_id  ) as attendee_industry,
                                                                                         (select group_concat(functionality.name) from attendee_has_functionality INNER JOIN functionality ON functionality.id = attendee_has_functionality.functionality_id  where attendee_id = E_A.attendee_id ) as attendee_functionality,
                                                                                         E_A.passcode as passcode,
                                                                                         A_T.name as attendee_name,
                                                                                         A_T.photo as attendee_image,
                                                                                         A_T.location as attendee_location,
                                                                                         A_T.city as attendee_city,
                                                                                         A_T.country as attendee_country,
                                                                                         A_T.description as attendee_description,
                                                                                         A_T.website as attendee_website,
                                                                                         A_T.linkden as attendee_linkdin,
                                                                                         A_T.twitter as attendee_twitter,
                                                                                         A_T.facebook as attendee_facebook,
                                                                                         A_T.profile,
                                                                                         A_T.attendee_type,
                                                                                         U_T.first_name,
                                                                                         U_T.last_name,
                                                                                         U_T.email as attendee_email,
                                                                                         U_T.company_name as attendee_company,
                                                                                         U_T.designation as attendee_designation,
                                                                                         U_T.phone as attendee_phone,
                                                                                          '
                                                                                      )
                                                                                -> from('event_has_attendee as E_A')          
                                                                                -> join('attendee as A_T','A_T.id = E_A.attendee_id')
                                                                                -> join('user as U_T','U_T.id = A_T.user_id');

        if($event_id)
            $this->db-> where('E_A.event_id',$event_id);
        
        if($this->attendee_type == 'S')
           $this->db->where('(A_T.attendee_type = "S")');
        elseif($this->attendee_type == 'A')
           $this->db->where('(A_T.attendee_type = "A")');
        else
           $this->db->where('(A_T.attendee_type = "A" OR A_T.attendee_type = "E")'); 
        
       if($attendee_id)
            $this->db-> where('A_T.id',$attendee_id);
       
       if($this->attendee_in_clause)
       {
           //display($this->attendee_in_clause);
           $this->db->where('E_A.attendee_id IN ('.implode(',',$this->attendee_in_clause).')');
       }
       
       if($this->search)
       {
            $this->db->join('attendee_has_industry as A_I','A_I.attendee_id = E_A.attendee_id','LEFT');
            $this->db-> join('industry as I_T','I_T.id = A_I.industry_id','LEFT');
            $this->db-> join('attendee_has_functionality as A_F','A_F.attendee_id = E_A.attendee_id','LEFT');
            $this->db-> join('functionality as F_T','F_T.id = A_F.functionality_id','LEFT');
            $this->db-> group_by('A_I.attendee_id');
            $this->db-> group_by('A_F.attendee_id');
            
            $temp                                                               = explode(',',$this->search);
            foreach($temp as $k => $v)
            {
                $search                                                         = $v;
                //if($search)
                $this->db->where("(A_T.name LIKE '$search%'|| U_T.first_name LIKE '%$search%' || U_T.last_name LIKE '%$search%' || U_T.designation LIKE '%$search%' || A_T.city LIKE '$search%' || A_T.country LIKE '$search%' || I_T.name LIKE '$search%' || F_T.name LIKE '$search%')");
            }
       }
       if(!is_null($this->limit))
            $this->db->limit($this->limit);
            //$this->db->limit($this->limit, $this->offset);
       
       
            
                                                                                
                
        $query_result                                                           = $this->db-> get();
        //show_query();
 
        return $query_result->result_array();
    }
    
    function getOrganizer($organizer_id=NULL,$event_id=NULL)
    {
        if($event_id)
            $this->db->where('E_T.id',$event_id);
        $query                                                                  =  $this->db
                                                                                -> select('O_T.name as organizer_name,E_T.name as event_name,U_T.email')
                                                                                -> from('event as E_T')
                                                                                -> join('organizer as O_T','O_T.id = E_T.organizer_id')
                                                                                -> join('user as U_T','U_T.id = O_T.user_id')
                                                                                -> get();
        $query_result                                                           = $query->row();
        return $query_result;
    }
    
    function getExhibitor($exhibitor_id=NULL,$event_id=NULL)
    {
        //echo '245';
        $exhibitor_query                                                        =  $this->db
                                                                                -> select(
                                                                                            'EX_T.id as exhibitor_id,
                                                                                             EX_T.name as exhibitor_name,
                                                                                             EX_T.is_featured as exhibitor_featured,
                                                                                             EX_T.stall_number,
                                                                                             EX_T.description as  exhibitor_description,
                                                                                             EX_T.status as exhibitor_status,
                                                                                             EX_P.website_link as exhibitor_website,
                                                                                             EX_P.facebook_link as exhibitor_facebook,
                                                                                             EX_P.twitter_link as exhibitor_twitter,
                                                                                             EX_P.linkedin_link as exhibitor_linkdin,
                                                                                             EX_P.city as exhibitor_city,
                                                                                             EX_P.country as exhibitor_country,
                                                                                             EX_P.location as exhibitor_location,
                                                                                             EX_P.logo as exhibitor_logo,
                                                                                             EX_P.image1,
                                                                                             EX_P.image2,
                                                                                             EX_P.brochure,
                                                                                             U_T.first_name ,
                                                                                             U_T.last_name,
                                                                                             U_T.email as exhibitor_email,
                                                                                             U_T.phone,
                                                                                             U_T.mobile,
                                                                                             A_T.id as attendee_id,
                                                                                             A_T.attendee_type,
                                                                                             A_T.name as attendee_name,
                                                                                             (select group_concat(industry.name) from exhibitor_has_industry INNER JOIN industry ON industry.id = exhibitor_has_industry.industry_id  where exhibitor_id = EX_T.id  ) as exhibitor_industry,
                                                                                             (select group_concat(functionality.name) from exhibitor_has_functionality INNER JOIN functionality ON functionality.id = exhibitor_has_functionality.functionality_id  where exhibitor_id = EX_T.id ) as exhibitor_functionality,
                                                                                             
                                                                                            '
                                                                                            
                                                                                          )  
                                                                                -> from('exhibitor as EX_T')          
                                                                                -> join('exhibitor_profile as EX_P','EX_P.exhibitor_id = EX_T.id')
                                                                                -> join('attendee as A_T','A_T.user_id = EX_T.contact_id')
                                                                                -> join('user as U_T','U_T.id = A_T.user_id')
                                                                                -> order_by('EX_T.is_featured','DESC')
                                                                                -> where('EX_T.status',1);
                if($event_id)
                    $this->db-> where('EX_T.event_id',$event_id);
                if($exhibitor_id)
                    $this->db-> where('A_T.id',$exhibitor_id);
                if($this->search)
                {
                    $search                                                     = $this->search;
                    /*$this->db->join('exhibitor_has_industry as EX_I','EX_I.attendee_id = E_A.attendee_id','LEFT');
                    $this->db-> join('industry as I_T','I_T.id = A_I.industry_id','LEFT');
                    $this->db-> join('attendee_has_functionality as A_F','A_F.attendee_id = E_A.attendee_id','LEFT');
                    $this->db-> join('functionality as F_T','F_T.id = A_F.functionality_id','LEFT');
                    $this->db-> group_by('A_I.attendee_id');
                    $this->db-> group_by('A_F.attendee_id');*/
                    $this->db->where("(EX_T.name LIKE '$search%'|| U_T.first_name LIKE '%$search%' || U_T.last_name LIKE '%$search%' || U_T.designation LIKE '%$search%' || EX_P.city LIKE '$search%' || EX_P.country LIKE '$search%' )");
                    $temp                                                               = explode(',',$this->search);
                    /*foreach($temp as $k => $v)
                    {
                        $search                                                         = $v;
                        //if($search)
                        //$this->db->where("(A_T.name LIKE '$search%'|| U_T.first_name LIKE '%$search%' || U_T.last_name LIKE '%$search%' || U_T.designation LIKE '%$search%' || A_T.city LIKE '$search%' || A_T.country LIKE '$search%' || I_T.name LIKE '$search%' || F_T.name LIKE '$search%')");
                    }*/
                }
            if(!is_null($this->limit))
            $this->db->limit($this->limit);
            //$this->db->limit($this->limit, $this->offset);
                    
                
        $query_result                                                           = $this->db-> get();
        //show_query();exit;
        return $query_result->result_array();
    }
    
    function getSpeaker($speaker_id=NULL,$event_id=NULL)
    {
        $session_query                                                          =  $this->db
                                                                                -> select(
                                                                                        'SPK_T.id as speaker_id,
                                                                                         SPK_T.name as speaker_name,
                                                                                         SPK_T.speaker_photo,
                                                                                         SPK_T.description as speaker_description,
                                                                                         SPK_T.city as speaker_city,
                                                                                         SPK_T.country as speaker_country,
                                                                                         SPK_T.website_link as speaker_website,
                                                                                         U_T.first_name,
                                                                                         U_T.last_name,
                                                                                         U_T.email as speaker_email,
                                                                                         U_T.company_name as speaker_company,
                                                                                         U_T.designation as speaker_designation,
                                                                                         U_T.phone as speaker_phone,
                                                                                         
                                                                                         
                                                                                         (select group_concat(industry.name) from speaker_has_industry INNER JOIN industry ON industry.id = speaker_has_industry.industry_id  where speaker_id = SPK_T.id  ) as speaker_industry,
                                                                                         (select group_concat(functionality.name) from speaker_has_functionality INNER JOIN functionality ON functionality.id = speaker_has_functionality.functionality_id  where speaker_id = SPK_T.id ) as speaker_functionality,
                                                                                         '
                                                                                      ) 
                                                                                -> from('speaker as SPK_T')          
                                                                                -> join('user as U_T','U_T.id = SPK_T.user_id')
                                                                                -> limit(10);
        if($event_id)
            $this->db-> where('SPK_T.event_id',$event_id);
        if($speaker_id)
            $this->db-> where('SPK_T.id',$speaker_id);
       if($this->speaker_in_clause)
       {
           $this->db->where('SPK_T.id IN ('.implode(',',$this->speaker_in_clause).')');
       }                                                                        
                
        $query_result                                                           = $this->db-> get();
        show_query();
        return $query_result->result_array();
    }
    
    function getSession($session_id=NULL,$event_id=NULL,$speaker_id=NULL)
    {
        //echo 'asfsdfgsdgf'.$event_id.$speaker_id;
        $session_query                                                          =  $this->db
                                                                                -> select(
                                                                                        'S_T.id as session_id,
                                                                                         S_T.name as session_name,
                                                                                         S_T.description as session_description,
                                                                                         S_T.start_time as session_start_time,
                                                                                         S_T.end_time as session_end_time,
                                                                                         S_T.session_date,
                                                                                         S_T.event_id,
                                                                                         S_T.upload as session_profile,
                                                                                         S_T.star as total_star,
                                                                                         S_T.total as total_feedback_count,
                                                                                         SPK_S.id as speaker_id,
                                                                                         SPK_S.name as speaker_name,
                                                                                         SPK_S.description as speaker_description,
                                                                                         SPK_S.speaker_photo,
                                                                                         SPK_S.speaker_profile,
                                                                                         SPK_S.city as speaker_city,
                                                                                         SPK_S.country as speaker_country,
                                                                                         SPK_S.website_link as speaker_website,
                                                                                         SPK_S.user_id,
                                                                                         TRK_T.name as track_name,
                                                                                         '
                                                                                      ) //S_A.attendee_id,
                                                                                -> from('session as S_T')          
                                                                                //-> join('session_has_attendee as S_A','S_A.session_id = S_T.id','LEFT')
                                                                                -> join('session_has_speaker as S_S','S_S.session_id = S_T.id','LEFT')
                                                                                -> join('speaker as SPK_S','SPK_S.id = S_S.speaker_id','LEFT')
                                                                                -> join('track as TRK_T','TRK_T.id = S_T.track_id','LEFT')
                                                                                //-> group_by('S_A.attendee_id')
                                                                                -> order_by('S_T.session_date')
                                                                                -> where('S_T.status',1);
        if($event_id)
            $this->db-> where('S_T.event_id',$event_id);
        if($session_id)
            $this->db-> where('S_T.id',$session_id);
        
        if($speaker_id)
            $this->db-> where('S_T.speaker_id',$speaker_id);
        
        if($this->attendee_in_clause)
        {
           //display($this->attendee_in_clause);
           $this->db->where('S_T.id IN ('.implode(',',$this->attendee_in_clause).')');
        }
//        if($this->attendee_id)
//            $this->db->where('S_A.attendee_id',$this->attendee_id);
                                                                                
                
        $query_result                                                           = $this->db-> get();
        //show_query();
        return $query_result->result_array();
    }
    
    
    function getSessionAttendee1()
    {
        
    }
    
    function getCount()
    {
        $result['total_attendee']                                               = $this->getAttendeeCount($this->event_id);
        $result['total_exhibitor']                                              = $this->getExhibitorCount($this->event_id);
        $result['total_speaker']                                                = $this->getSpeakerCount($this->event_id);
        return $result;
    }
    
    function getAttendeeCount($event_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('COUNT(distinct A_T.id) as total_attendee')
                                                                                -> from('attendee as A_T')
                                                                                -> join('event_has_attendee as E_A','E_A.attendee_id = A_T.id')
                                                                                ->where('(A_T.attendee_type = "A" OR A_T.attendee_type = "E")')     
                                                                                ->where('E_A.event_id',$event_id)    
                                                                                ->where('A_T.mail_sent',1);    
//        if($event_id)
//            $this->db->where('E_A.event_id',$event_id);
        $query_result                                                           = $this->db-> get();
        $result                                                                 = $query_result->result_array();
        return @$result[0]['total_attendee'];
                
    }
    function getSpeakerCount($event_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('COUNT(distinct A_T.id) as total_attendee')
                                                                                -> from('attendee as A_T')
                                                                                -> join('event_has_attendee as E_A','E_A.attendee_id = A_T.id')
                                                                                ->where('A_T.attendee_type','S')  
                                                                                ->where('A_T.mail_sent',1)  
                                                                                ->where('E_A.event_id',$event_id);
                                                                                    
//        if($event_id)
//            $this->db->where('E_A.event_id',$event_id);
        $query_result                                                           = $this->db-> get();
        $result                                                                 = $query_result->result_array();
        return @$result[0]['total_attendee'];
        
    }
    function getExhibitorCount($event_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('COUNT(distinct E_T.id) as total_exhibitor')
                                                                                -> from('exhibitor as E_T');
        if($event_id)
            $this->db->where('E_T.event_id',$event_id);
        $query_result                                                           = $this->db-> get();
        $result                                                                 = $query_result->result_array();
        return @$result[0]['total_exhibitor'];
    }
    
    function getSpeakerHasSession($session_id=NULL,$event_id,$speaker_id)
    {
        //echo 'fvsdgvsd'.$event_id.$speaker_id;
        $session_query                                                          =  $this->db
                                                                                -> select(
                                                                                        'S_T.id as session_id,
                                                                                         S_T.name as session_name,
                                                                                         S_T.description as session_description,
                                                                                         S_T.start_time as session_start_time,
                                                                                         S_T.end_time as session_end_time,
                                                                                         S_T.session_date,
                                                                                         S_T.event_id,
                                                                                         TRK_T.name as track_name,
                                                                                         
                                                                                         '
                                                                                      ) //S_A.attendee_id,
                                                                                -> from('session_has_speaker as S_S')          
                                                                                -> join('session as S_T','S_T.id = S_S.session_id')
                                                                                -> join('attendee as A_T','A_T.id = S_S.speaker_id')
                                                                                -> join('track as TRK_T','TRK_T.id = S_T.track_id','LEFT')
                                                                                //-> group_by('S_A.attendee_id')
                                                                                -> order_by('S_T.session_date');
                                                                                //-> where('S_T.status',1);
        if($event_id)
            $this->db-> where('S_T.event_id',$event_id);
        if($session_id)
            $this->db-> where('S_T.id',$session_id);
        
        if($speaker_id)
            $this->db-> where('S_S.speaker_id',$speaker_id);
        
        if($this->attendee_in_clause)
        {
           //display($this->attendee_in_clause);
           $this->db->where('S_T.id IN ('.implode(',',$this->attendee_in_clause).')');
        }
//        if($this->attendee_id)
//            $this->db->where('S_A.attendee_id',$this->attendee_id);
                                                                                
                
        $query_result                                                           = $this->db-> get();
        //show_query();
        return $query_result->result_array();
    }
    
    function getSessionAttendee($session_id,$session_attendee_id,$event_id=NULL)
    {
        $session_attendee                                                       = array();        
        $query                                                                  = $this->db
                                                                                -> select('attendee_id')
                                                                                -> from('session_has_attendee')
                                                                                -> where('session_id',$session_id)
                                                                                //-> where_not_in('attendee_id',$session_attendee_id)
                                                                                -> get();
        $result                                                                 = $query->result_array();
        //display($result);
        if($result)
        {
            foreach ($result as $key => $value) 
            {
                $session_attendee['id'][]                                               = $value['attendee_id'];//$this->getAttendee($value['attendee_id'], $event_id);
                
                  
            }
            //display($session_attendee);
            if($session_attendee)
            {
                $this->attendee_in_clause                                       = $session_attendee['id'];
                $session_attendee                                               = $this->getAttendee(NULL, $event_id);  
            }
        }
        //display($session_attendee);exit;
        return $session_attendee;
    }
    
    function getAttendeeHasSession($attendee_id,$event_id=NULL)
    {
        $attendee_has_session                                                   = array();        
        $query                                                                  = $this->db
                                                                                -> select('session_id')
                                                                                -> from('session_has_attendee')
                                                                                -> where('attendee_id',$attendee_id)
                                                                                -> get();
        $result                                                                 = $query->result_array();
        //display($result);
        if($result)
        {
            foreach ($result as $key => $value) 
            {
                $attendee_session['id'][]                                               = $value['session_id'];//$this->getAttendee($value['attendee_id'], $event_id);
                
                  
            }
            //display($session_attendee['id']);
            if($attendee_session)
            {
                
                $this->attendee_in_clause                                       = $attendee_session['id'];
                //display($this->attendee_in_clause);
                $attendee_has_session                                           = $this->getSession(NULL, $event_id);  
            }
        }
        //
        //display($attendee_has_session);exit;
        return $attendee_has_session;
    }
    
    function getPriviousEvents($attendee_id=NULL,$speaker_id=NULL)
    {
        //echo 
        $result                                                                 = array();
        $previous_event                                                         = array();    
        if($attendee_id)
        {
            //echo 'test';
            $query                                                              =  $this->db
                                                                                -> select('event_id')
                                                                                -> from('event_has_attendee')
                                                                                -> where('attendee_id',$attendee_id)
                                                                                -> get();
            $result                                                             = $query->result_array();
            //display($result);
        }
        if($speaker_id)
        {
            //echo 'test';
            $query                                                              =  $this->db
                                                                                -> select('S_T.event_id')
                                                                                -> from('session_has_speaker as S_SP')
                                                                                -> join('session  as S_T','S_T.id = S_SP.session_id')
                                                                                -> where('S_SP.speaker_id',$speaker_id)
                                                                                -> group_by('S_T.event_id')
                                                                                -> get();
                                                                        //show_query();
            $result                                                             = $query->result_array();
        }
        if($result)
        {
            foreach($result as $key=> $value)
            {
                $event_id['id'][]                                               = $value['event_id'];
            }
            if($event_id)
            {
                $this->attendee_in_clause                                       = $event_id['id'];
                $this->event_detail                                             = TRUE;
                $previous_event                                                 = $this->getAll(NULL, NULL);  
            }
        }
        //display($previous_event);
        return @$previous_event['event_list'];
    }
    
    function getSessionAttendeeCount($session_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('COUNT(distinct S_T.attendee_id) as total_session_attendee')
                                                                                -> from('session as S_T')
                                                                                ->where('S_T.session_id',$session_id);
        
        $query_result                                                           = $this->db-> get();
        $result                                                                 = $query_result->result_array();
        return @$result[0];
    }
    
    function getSessionHasSpeaker($session_id,$event_id)
    {
        $session_speaker                                                        = array();        
        $query                                                                  = $this->db
                                                                                -> select('speaker_id')
                                                                                -> from('session_has_speaker')
                                                                                -> where('session_id',$session_id)
                                                                                //-> where_not_in('attendee_id',$session_attendee_id)
                                                                                -> get();
        $result                                                                 = $query->result_array();
        //display($result);
        if($result)
        {
            foreach ($result as $key => $value) 
            {
                $session_speaker['id'][]                                        = $value['speaker_id'];
                  
            }
            if($session_speaker)
            {
                $this->attendee_in_clause                                        = $session_speaker['id'];
                //display($this->speaker_in_clause);
                $session_speaker                                                = $this->getAttendee(NULL, $event_id);  
            }
        }
        //display($session_speaker);exit;
        return $session_speaker;
    }
    
    function getSessionQuestion($session_id,$event_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('S_Q.question,S_Q.created_date,A_T.name,U_T.designation,U_T.company_name')
                                                                                -> from('session_question as S_Q')
                                                                                -> join('attendee as A_T','A_T.id = S_Q.attendee_id')
                                                                                -> join('user as U_T','U_T.id = A_T.user_id')
                                                                                -> where('session_id',$session_id)
                                                                                -> get();
        
                                                                       
        return $query->result_array();
    }
    
    function getIndustry($id= NULL)
    {
        $query                                                                  =  $this->db
                                                                                -> select('id,name')
                                                                                -> from('industry')
                                                                                -> where('status',1)
                                                                                -> get();
        return $query->result_array();
    }
    
    function getFunctionality($id= NULL)
    {
        $query                                                                  =  $this->db
                                                                                -> select('id,name')
                                                                                -> from('functionality')
                                                                                -> where('status',1)
                                                                                -> get();
        return $query->result_array();
    }
   
    
    function getUser($email=NULL,$password=NULL,$user_id=NULL,$status=NULL)
    {
        $query                                                                  =  $this->db
                                                                                -> select(
                                                                                          ' id as user_id,
                                                                                            email,
                                                                                            first_name,
                                                                                            last_name,
                                                                                            username,
                                                                                            type_of_user,
                                                                                            status,
                                                                                            linkden,
                                                                                            facebook,
                                                                                            twitter,
                                                                                            googleplus,
                                                                                            '
                                                                                          )
                                                                                -> from('user');
        if($email && $password)
        {
            $this->db->where('email',  $email);
            $this->db->where('password',  md5($password));
            //$this->db->where('type_of_user = "A" || type_of_user = "S"');//to allow only attendee and speaker
        }
        
        if($email)
            $this->db->where('email',  $email); 
        
        if($user_id)
           $this->db->where('id',  $user_id); 
        if($status)
           $this->db->where('status',  $status); 
                                                                                
                                                                                
        $query_result                                                           = $this->db->get();
        //echo $this->db->last_query();
        return $query_result->result_array();
                                                                                    
    }

    
    
    function checkAttendee($event_id,$attendee_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('passcode')
                                                                                -> from('event_has_attendee as E_A')
                                                                                -> where('E_A.attendee_id',$attendee_id)
                                                                                -> where('E_A.event_id',$event_id)
                                                                                -> get();
        
        return $query->result_array();
    }

    function insert_attendee($attendee_id,$event_id)
    {
        $passcode                                                               = generatePassword(6);
        $table_array                                                            = array(
                                                                                        'event_id'          => $event_id,
                                                                                        'attendee_id'       => $attendee_id,
                                                                                        'status'            => 0,
                                                                                        'passcode'          => $passcode,
                                                                                        'pvt_org_id'        => 1,
                                                                                        );  
        $this->db->insert('event_has_attendee',$table_array);
        return $passcode;
    }
    
    function check_passcode($event_id,$attendee_id,$passcode=NULL)
    {
        if($passcode)
        {
            $this->db-> where('E_A.passcode',$passcode);
            $this->db->or_where('E_A.passcode',  strtolower($passcode));
            $this->db->or_where('E_A.passcode', strtoupper($passcode));
        }
        else
            $this->db-> where('E_A.status',1);
        
        $query                                                                  =  $this->db
                                                                                -> select('E_A.attendee_id,E_A.status')
                                                                                -> from('event_has_attendee as E_A')
                                                                                -> from('attendee as A_T','A_T.id = E_A.attendee_id')
                                                                                -> where('E_A.event_id',$event_id)
                                                                                -> where('E_A.attendee_id',$attendee_id)
                                                                                -> get();
        
        
        return $query->result_array();
    }
    
    function do_rsvp($session_id,$attendee_id)
    {
        $table_array                                                            = array(
                                                                                        'session_id'        => $session_id,
                                                                                        'attendee_id'       => $attendee_id,
                                                                                        'pvt_org_id'        => 1
                                                                                        );
        $this->db->insert('session_has_attendee',$table_array);
    }
    
    function getMessageCounter($attendee_id,$target_attendee_id)
    {
        $check_message_query                                                    =  $this->db
                                                                                -> select('message_id as message_count')
                                                                                -> from('notification_user')
                                                                                -> where_not_in('message_id',0)
                                                                                -> where('type','Msg')
                                                                                -> where("((subject_id = $attendee_id AND object_id = $target_attendee_id) OR (subject_id = $target_attendee_id  AND object_id = $attendee_id))")
                                                                                -> get();
        $query_result                                                           = $check_message_query->row();
        if($query_result)
            return $query_result;
                                                                                
                
                
        $query                                                                  =  $this->db
                                                                                -> select('message_count')
                                                                                -> from('message_counter')
                                                                                -> get();
        $result                                                                 = $query->row();
        $this->db->update('message_counter',array('message_count' => $result->message_count+1));
        //display($result);
        
        return $result;
    }
    
    
    function send_mesage($attendee_id,$message_id,$target_attendee_id,$target_type,$message,$event_id)
    {
        //echo $event_id;
        $table_array                                                            = array(
                                                                                        'message_id'            => $message_id,
                                                                                        'type'                  => 'Msg',
                                                                                        'display_time'          => date('Y-m-d H:i:s'),
                                                                                        'object_id'            => $attendee_id,
                                                                                        'object_type'          => $this->session->userdata('client_user_type'),
                                                                                        'event_id'              => $event_id,
                                                                                        'read'                  => 0,
                                                                                        'content'               => $message,
                                                                                        'status'                => 1,
                                                                                        'created_date'          => date('Y-m-d H:i:s')
                                                                                        );
        //display($table_array);
        if($this->broadcast_msg)
        {
            $table_array['subject_id']                                           = 0;
            $table_array['subject_type']                                         = 0;
        }
        else
        {
            $table_array['subject_id']                                           = $target_attendee_id;
            $table_array['subject_type']                                         = $target_type;
            
        }
        
        
        $this->db->insert('notification_user',$table_array);
        return $this->db->insert_id();
    }
    
    function insert_mesagess_query($table_array)
    {
        $this->db->insert('notification_user',$table_array);
        return $this->db->insert_id();
    }
            
    function getActiveAttendee($event_id,$attendee_id= NULL)
    {
        $query                                                                  =  $this->db
                                                                                -> select('A_T.id,A_T.name,A_T.attendee_type')
                                                                                -> from('event_has_attendee as E_A')
                                                                                -> join('attendee as A_T','A_T.id = E_A.attendee_id')
                                                                                -> where('E_A.event_id',$event_id)
                                                                                //-> where('E_A.status',1)
                                                                                -> get();
        return $query->result_array();
    }
    
    function getRsvpSession($attendee_id,$tareget_attendee_id,$event_id)
    {
        
        
        $query                                                                  =  $this->db
                                                                                -> select('
                                                                                         S_A.session_id,
                                                                                         S_T.name as session_name,
                                                                                         S_T.start_time as session_start_time,
                                                                                         S_T.end_time as session_end_time,
                                                                                         S_T.session_date,
                                                                                         S_A.attendee_id as object_id,
                                                                                         S_T.event_id')
                                                                                -> from('session_has_attendee as S_A')
                                                                                -> join('session as S_T','S_T.id = S_A.session_id')
                                                                                -> where('(S_A.attendee_id = '.$attendee_id.' OR S_A.attendee_id ='.$tareget_attendee_id.')')
                                                                                -> order_by('S_T.session_date')
                                                                                -> where('S_T.status',1)
                                                                                -> get();
        return $query->result_array();
    }
    
    function getMeeting($from_id,$to_id,$event_id)
    {
        
        $query                                                                  =  $this->db
                                                                                -> select('M_T.start_time as session_start_time,M_T.end_time as session_end_time,M_T.message as session_name,N_U.event_id,N_U.object_id,N_U.subject_id')
                                                                                -> from ('notification_user as N_U')
                                                                                -> join('meeting M_T','M_T.id = N_U.meeting_id')
                                                                                -> where('N_U.type','Mtg')
                                                                                -> where('M_T.approve',1)
                                                                                -> where('(N_U.object_id = '.$from_id.' OR N_U.subject_id = '.$from_id.' OR N_U.object_id = '.$to_id.' OR N_U.subject_id = '.$to_id.')')
                                                                                -> get();
        return $query->result_array();
    }
    
    
    
    function set_meeting($data)
    {
        $meeting_table                                                          = array(
                                                                                        'subject_id'        => $data['target_id'],
                                                                                        'subject_type'      => $data['target_type'],
                                                                                        'object_id'         => $data['attendee_id'],
                                                                                        'object_type'       => $data['attendee_type'],
                                                                                        'message'           => $data['title'],
                                                                                        'approve'           => 0,
                                                                                        'start_time'        => $data['start_time'],
                                                                                        'end_time'          => $data['end_time'],
                                                                                        'status'            => 1,
                                                                                        'created_date'      => date('Y-m-d H:i:s'),
                                                                                        'pvt_org_id'        => 1,
                                                                                        );
        $this->db->insert('meeting',$meeting_table);
        $meeting_id                                                             = $this->db->insert_id();
        
        $notification_table                                                     = array(
                                                                                        'meeting_id'        => $meeting_id,
                                                                                        'type'              => 'Mtg',
                                                                                        'display_time'      => date('Y-m-d H:i:s'),
                                                                                        'subject_id'        => $data['target_id'],
                                                                                        'subject_type'      => $data['target_type'],
                                                                                        'object_id'         => $data['attendee_id'],
                                                                                        'object_type'       => $data['attendee_type'],
                                                                                        'event_id'          => $data['event_id'],
                                                                                        'read'              => 0,
                                                                                        'content'           => $data['title'],
                                                                                        'status'            => 1,
                                                                                        'created_date'      => date('Y-m-d H:i:s'),
                                                                                        'pvt_org_id'        => 1,
                                                                                        );
        $this->db->insert('notification_user',$notification_table);
        return $this->db->insert_id();
                
    }
    
    function reply_meeting($data)
    {
        $msg                                                                    = '';
        $notification_table                                                     = array(
                                                                                        'type'              => 'N',
                                                                                        'display_time'      => date('Y-m-d H:i:s'),
                                                                                        'subject_id'        => $data['target_id'],
                                                                                        'subject_type'      => $this->getAttendeeType($data['target_id']),
                                                                                        'object_id'         => $data['attendee_id'],
                                                                                        'object_type'       => $data['attendee_type'],
                                                                                        'event_id'          => $data['event_id'],
                                                                                        'read'              => 0,
                                                                                        'content'           => $data['meeting_reply_text'],
                                                                                        'status'            => 1,
                                                                                        'created_date'      => date('Y-m-d H:i:s'),
                                                                                        'pvt_org_id'        => 1,
                                                                                );
        if($data['responce'] == 'approve')
        {
            //update
            $query                                                              = $this->db->get_where('meeting', array('id' => $data['meeting_id'],'approve'=> 1));
            $get_meeting                                                        = $query->row();
            //display($get_meeting);
            if($get_meeting)
            {
                $msg                                                            = 'This slot is already booked';
                return $msg;
            }
            else 
            {
                $this->db->where('id',$data['meeting_id']);
                $this->db->update('meeting',array('approve'=>1));
                $msg                                                            = 'Meeting Set Successfully!';
            }
        }
        elseif($data['responce'] == 'decline')
        {
            $msg                                                                = 'You declined Successfully';
            $this->db->where('id',$data['meeting_id']);
            $this->db->update('meeting',array('approve'=>2));
            //show_query();
        }
        $this->db->insert('notification_user',$notification_table);
        return $msg;
    }
    
    function check_slot($target_id,$start_time,$end_time)
    {
        $query                                                                  = $this->db
                                                                                -> select('id')
                                                                                -> from('meeting')
                                                                                -> where('(object_id = ' .$target_id.' OR subject_id ='.$target_id.' )')
                                                                                //-> or_where('subject_id',$target_id)
                                                                                //-> where('start_time',$start_time)
                                                                                //-> where('end_time',$end_time)
                                                                                -> where('(start_time <= "'.$start_time. '" AND end_time >= "'.$end_time.'")')
                                                                                -> where('approve',1)
                                                                                -> get();
        $meeting_result                                                         =  $query->row();
        //show_query();
        if($meeting_result)
            return $meeting_result;
        
        $query2                                                                  =  $this->db
                                                                                -> select('S_A.session_id')
                                                                                -> from('session_has_attendee as S_A')
                                                                                -> join('session as S_T','S_T.id = S_A.session_id')
                                                                                -> where('S_A.attendee_id ',$target_id)
                                                                                -> where('(S_T.start_time <= "'.$start_time. '" AND S_T.end_time >= "'.$end_time.'")')
                                                                                -> order_by('S_T.session_date')
                                                                                -> where('S_T.status',1)
                                                                                -> get();
        $result                                                                 = $query2->row();
        //show_query();
        return $result;
    }
    
    
    
    function getAttendeeType($attendee_id)
    {
        if($attendee_id)
        {
            $query                                                              =  $this->db
                                                                                -> select('attendee_type')
                                                                                -> from('attendee')
                                                                                -> where('id',$attendee_id)
                                                                                -> get()->row();
            return @$query->attendee_type;
        }
    }
    
    function getName($attendee_id)
    {
        if($attendee_id)
        {
            $query                                                              =  $this->db
                                                                                -> select('U_T.first_name')
                                                                                -> from('user as U_T')
                                                                                -> join('attendee as A_T','A_T.user_id = U_T.id')
                                                                                -> where('A_T.id',$attendee_id)
                                                                                -> get()->row();
            return @$query->first_name;
        }
    }
    
    
    function getHashTag($event_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('twitter')
                                                                                -> from('event_profile')
                                                                                -> where('event_id',$event_id)
                                                                                -> get()->row();
        return @$query->twitter;
    }
    
    function getEventDate($event_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('event_start,event_end')
                                                                                -> from('event')
                                                                                -> where('id',$event_id)
                                                                                -> get()->row();
        return $query;
    }
    
    function push_analytics($type,$object_id,$object_type,$subject_id,$subject_type,$event_id)
    {
        if($type == 'download')
        {
            if($subject_type == 'Event')
                $type = 'download_evt_map';
            elseif($subject_type == 'Session')
                $type = 'download_ses_map';
            elseif($subject_type == 'E')
                $type = 'download_exe_map';
            elseif($subject_type == 'S')
                $type = 'download_spe_map';
        }
        
        
        $insert_array                                                           = array(
                                                                                        'object_id'         => $object_id,
                                                                                        'object_type'       => $object_type,
                                                                                        'subject_id'        => $subject_id,
                                                                                        'subject_type'      => $subject_type,
                                                                                        'type'              => $type,
                                                                                        'created_date'      => date('Y-m-d H:i:s'),
                                                                                        'event_id'          => $event_id,
                                                                                        'pvtorgid'          => 1,
                                                                                        );
        $this->db->insert('analytics',$insert_array);
    }
}

?>
