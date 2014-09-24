<?php

class client_user_model extends CI_Model {

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
    public $attendee_in_clause                                                  = NULL;
    public $event_detail                                                        = FALSE;
   
            

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
   
    
    function getIndustry($id= NULL,$industry)
    {
        $query                                                                  =  $this->db
                                                                                -> select('id')
                                                                                -> from('industry')
                                                                                -> where('status',1);
        if($industry)
        {
            $this->db->where("name",  $industry);
        }
        $query_result                                                           = $this->db->get();
        return $query_result->result_array();
    }
    
    function getFunctionality($id= NULL,$functionality)
    {
        $query                                                                  =  $this->db
                                                                                -> select('id')
                                                                                -> from('functionality')
                                                                                -> where('status',1);
        if($functionality)
        {
            $this->db->where("name",  $functionality);
        }
        $query_result                                                           = $this->db->get();
        return $query_result->result_array();
    }
    
    function save_industry_functionality($table,$data)
    {
        $table_array                                                            = array(
                                                                                            'name'          => $data,
                                                                                            'status'        => 1,
                                                                                            'created_date'  => date('Y-m-d H:i:s'),
                                                                                        );
        
        $this->db->insert($table,$table_array);
        return $this->db->insert_id();
    }
    
    
    function save_user($id=NULL,$data)
    {
        display($data);
        $user_table                                                             = array(
                                                                                        'first_name'            => $data['first_name'],
                                                                                        'last_name'             => $data['last_name'],
                                                                                        'email'                 => $data['email'],
                                                                                        'type_of_user'          => 'A',
                                                                                        'status'                => 1,
                                                                                        'pvt_org_id'            => 1,
                                                                                        'linkden'               => $data['likedin_id'],
                                                                                        'company_name'          => $data['company'],
                                                                                        'designation'           => $data['designation'],
                                                                                        );
        
        $attendee_table                                                         = array(
                                                                                        'name'                  => $data['user_table']['first_name'].' '.$data['user_table']['last_name'],
                                                                                        'location'              => $data['location'],
                                                                                        'city'                  => $data['city'],
                                                                                        'country'               => $data['country'],
                                                                                        'photo'                 => $data['profile_pic'],
                                                                                        'status'                => 1,
                                                                                       
                                                                                        'user_id'               => $user_id,
                                                                                        'attendee_type'         => 0,
                                                                                        'pvt_org_id'            => 1,
                                                                                        );
        
        if($id)
        {
            //update
        }
        else
        {
            //insert
            $user_table['created_date']                                         = data('Y-m-d H:i:s');        
            //$this->db->insert('user',$user_table);
            
            $user_id                                                            = $this->db->insert_id();
            
            $attendee_table['created_date' ]                                    = date('Y-m-d H:i:s');
            $attendee_table['user_id']                                          = $user_id;
        }
        
        
        
        
        //$this->db->insert('attendee',$attendee_table);
        $attendee_id                                                            = $this->db->insert_id();
        if($data['industry_id'])
        {
            $industry_table                                                     = array(
                                                                                        'attendee_id'       => $attendee_id,     
                                                                                        'industry_id'       => $data['industry_id']     
                                                                                        );
            
            //$this->db->insert('attendee_has_industry',$industry_table);
        }
        if($data['functionality_id'])
        {
            foreach($data['functionality_id'] as $key => $value)
            {
                $functionality_table                                                = array(
                                                                                        'attendee_id'       => $attendee_id,     
                                                                                        'functionality_id'  => $value     
                                                                                        );
            
                //$this->db->insert('attendee_has_functionality',$industry_table);
            }
            
        }
        
        return $user_id;
    }
    
    function getUser()
    {
        
    }
    
    function check_user($user_id=NULL,$email)
    {
        $query                                                                  =  $this->db
                                                                                -> select('id,email,status,type_of_user,first_name')
                                                                                -> from('user');
        if($email)
            $this->db->where('email',$email);
        if($user_id)
            $this->db->where('id',$user_id);
        
        $query_result                                                           = $this->db->get();
        $result                                                                 = $query_result->result_array();
        //display($result);
        return @$result[0];
                
    }
   
    
    
}

?>
