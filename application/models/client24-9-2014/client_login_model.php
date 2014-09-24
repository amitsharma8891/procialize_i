<?php

class client_login_model extends CI_Model {

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
    public $password                                                            = NULL;
    public $insert_type                                                          = NULL;
   
            

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
                                                                                -> select('id,name')
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
                                                                                -> select('id,name')
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
    
    
    function save_user($user_id=NULL,$data)
    {
        //display($data);exit;
        $subscribe_email                                                        = 0;
        if(isset($data['sbscribe_email']))
            $subscribe_email                                                    = 1;
        elseif($data['social_type'] == 'facebook' || $data['social_type'] == 'linkedin')
            $subscribe_email                                                    = 1;
        
        
        $user_table                                                             = array(
                                                                                        'first_name'            => mysql_real_escape_string($data['first_name']),
                                                                                        'last_name'             => mysql_real_escape_string($data['last_name']),
                                                                                        'type_of_user'          => $data['type_of_attendee'],
                                                                                        'status'                => 1,
                                                                                        'phone'                 => 1,
                                                                                        'pvt_org_id'            => 1,
                                                                                        'top_level_id'          => 1,
                                                                                        );
        
        if($data['social_type'] != 'facebook')
        {
            $user_table['company_name']                                         = mysql_real_escape_string($data['company']);
            $user_table['designation']                                          = mysql_real_escape_string($data['designation']);
        }
            
        $attendee_table                                                         = array(
                                                                                        'name'                  => mysql_real_escape_string($data['first_name']).' '.mysql_real_escape_string($data['last_name']),
                                                                                        'description'           => mysql_real_escape_string($data['description']),
                                                                                        'location'              => mysql_real_escape_string($data['location']),
                                                                                        'city'                  => mysql_real_escape_string($data['city']),
                                                                                        'country'               => mysql_real_escape_string($data['country']),
                                                                                        'photo'                 => @mysql_real_escape_string($data['profile_pic']),
                                                                                        'status'                => 1,
                                                                                        'attendee_type'         => $data['type_of_attendee'],
                                                                                        'subscribe_email'       => $subscribe_email,
                                                                                        'pvt_org_id'            => 1,
                                                                                        );
        
        
        if($user_id)
        {
            if($this->insert_type == 'normal')
            {
                if(isset($data['current_password']) && $data['current_password'] != '' )
                $user_table['password']                                         = md5($data['password']);
                
                $user_table['mobile']                                           = mysql_real_escape_string($data['mobile']);
                $user_table['phone']                                            = mysql_real_escape_string($data['phone']);
                $attendee_table['website']                                      = mysql_real_escape_string($data['website']);
                
            } 
            //update
            $attendee_id                                                        = $this->attendee_id;
            $user_table['modified_date']                                        = date('Y-m-d H:i:s');
            
            $this->db->where('id',$user_id);
            $this->db->update('user',$user_table);
            
            $attendee_table['modified_date']                                        = date('Y-m-d H:i:s');
            
            $this->db->where('user_id',  $user_id);
            $this->db->update('attendee',$attendee_table);
            $email                                                              = $this->session->userdata('client_email');
        }
        else
        {
            //insert
            
            if($this->insert_type == 'normal')
            {
                $user_table['password']                                         = md5($data['password']);
                $user_table['mobile']                                           = mysql_real_escape_string($data['mobile']);
                $user_table['phone']                                            = mysql_real_escape_string($data['phone']);
                $attendee_table['website']                                      = mysql_real_escape_string($data['website']);
                
            } 
            if($data['social_type'] == 'linkedin')
            {
                $user_table['linkden']                                          = mysql_real_escape_string($data['linkedin_id']);
                $attendee_table['linkden']                                      = $data['public_profile_url'];
            }
            elseif($data['social_type'] == 'facebook')
            {
                $user_table['facebook']                                          = mysql_real_escape_string($data['fb_id']);
                $attendee_table['facebook']                                      = $data['public_profile_url'];
            }
            $user_table['email']                                                = mysql_real_escape_string($data['email']);
            
            
            $user_table['created_date']                                         = date('Y-m-d H:i:s');        
            $this->db->insert('user',$user_table);
            
            $user_id                                                            = $this->db->insert_id();
            
            $attendee_table['created_date' ]                                    = date('Y-m-d H:i:s');
            $attendee_table['user_id']                                          = $user_id;
            $this->db->insert('attendee',$attendee_table);
            $attendee_id                                                        = $this->db->insert_id();
            $email                                                              = $data['email'];
        }
        
        
        
        
        //
        
        if($data['industry_id'])
        {
            $this->db->where('attendee_id',$attendee_id);
            $this->db->delete('attendee_has_industry');//remove previous data
            foreach($data['industry_id'] as $k => $v)
            {
                $industry_table                                                     = array(
                                                                                        'attendee_id'       => $attendee_id,     
                                                                                        'industry_id'       => $v     
                                                                                        );
            
                $this->db->insert('attendee_has_industry',$industry_table);
            }
            
        }
        if($data['functionality_id'])
        {
            $this->db->where('attendee_id',$attendee_id);
            $this->db->delete('attendee_has_functionality');//remove previous data
                
            foreach($data['functionality_id'] as $key => $value)
            {
                if($value)
                {
                    $functionality_table                                                = array(
                                                                                        'attendee_id'       => $attendee_id,     
                                                                                        'functionality_id'  => $value     
                                                                                        );
            
                    $this->db->insert('attendee_has_functionality',$functionality_table);
                }
                
            }
            
        }
        
        $ids                                                                    = array('user_id'=> $user_id,'attendee_id'=>$attendee_id,'email'=>$email);
        return $ids;
        
    }
    
  
    
    function check_user($user_id=NULL,$email)
    {
        $query                                                                  =  $this->db
                                                                                -> select(
                                                                                            'U_T.id,
                                                                                            U_T.email,
                                                                                            U_T.status,
                                                                                            U_T.type_of_user,
                                                                                            U_T.first_name,
                                                                                            U_T.linkden,
                                                                                            U_T.facebook,
                                                                                            U_T.company_name,
                                                                                            U_T.designation,
                                                                                            A_T.id as attendee_id,
                                                                                            A_T.name,A_T.photo,
                                                                                            A_T.city,A_T.attendee_type,
                                                                                            (select group_concat(industry.name) from attendee_has_industry INNER JOIN industry ON industry.id = attendee_has_industry.industry_id  where attendee_id = A_T.id  ) as attendee_industry
                                                                                            ')
                                                                                -> from('user as U_T')
                                                                                -> join('attendee as A_T','A_T.user_id = U_T.id');
        if($email)
            $this->db->where('email',$email);
        if($user_id)
            $this->db->where('id',$user_id);
        
        if($this->password)
            $this->db->where('password',md5($this->password));
        
        $query_result                                                           = $this->db->get();
        $result                                                                 = $query_result->result_array();
        //show_query();
        //display($result);
        return @$result[0];
                
    }
    
    function getUserData($attendee_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select
                                                                                        (
                                                                                        '(select group_concat(attendee_has_industry.industry_id) from attendee_has_industry where attendee_id = ' . $attendee_id . ') as industry_id,   
                                                                                        (select group_concat(attendee_has_functionality.functionality_id) from attendee_has_functionality where attendee_id = ' . $attendee_id . ') as functionality_id,    
                                                                                        U_T.first_name,
                                                                                        U_T.last_name,
                                                                                        U_T.email,
                                                                                        U_T.password,
                                                                                        U_T.type_of_user,
                                                                                        U_T.status,
                                                                                        U_T.company_name,
                                                                                        U_T.designation,
                                                                                        U_T.phone,
                                                                                        U_T.mobile,
                                                                                        A_T.name,
                                                                                        A_T.description,
                                                                                        A_T.location,
                                                                                        A_T.city,
                                                                                        A_T.country,
                                                                                        A_T.photo,
                                                                                        A_T.attendee_type,
                                                                                        A_T.website,
                                                                                        A_T.subscribe_email,
                                                                                        '
                                                                                        )
                                                                                -> from('user as U_T')
                                                                                -> join('attendee as A_T','A_T.user_id = U_T.id')
                                                                                -> where('A_T.id',$attendee_id)
                                                                                -> where('A_T.status',1)
                                                                                -> get();
        return $query->row();
    }
   
    
    function CheckPasswordKey($password_key)
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
                                                                                -> from('user')
                                                                                -> where('password_key',$password_key)
                                                                                ->get();
        return $query->row();
                                                                                    
    }
    
    function reset_password($data)
    {
        $update_pass                                                            = array(
                                                                                        'password'          => md5($data['password']),
                                                                                        'modified_date'     => date('Y-m-d H:i:s'),
                                                                                        'password_key'      => ''
                                                                                        );
        $this->db->where('password_key',$data['password_key']);
        $this->db->update('user',$update_pass);
        //show_query();
    }
    
    function getPassword($attendee_id)
    {
        $query                                                                  =  $this->db
                                                                                -> select('U_T.password')
                                                                                -> from('user as U_T')
                                                                                -> join('attendee as A_T','A_T.user_id = U_T.id')
                                                                                -> where('A_T.id',$attendee_id)
                                                                                -> where('A_T.status',1)
                                                                                -> get()->row();
        return $query->password;
    }
    
    
}

?>
