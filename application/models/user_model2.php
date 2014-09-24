<?php

class user_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        //$this->load->database();
        $this->load->model('organizer_model');
        $this->load->model('exhibitor_model');
    }

    public $fields = array(
        "id",
        "first_name",
        "last_name",
        "email",
        "username",
        "password",
        "type_of_user",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "top_level_id",
        "is_superadmin",
        "pvt_org_id",
        "linkden",
        "facebook",
        "twitter",
        "googleplus",
        "company_name",
        "designation",
        "phone",
        "mobile"
    );

    function generate_fields($id = NULL) {

        $arrResult = array();
        if (!is_null($id))
            $arrResult = $this->get($id, TRUE);

        $functionality_list = $this->get_functionality();
        $functionality_options = array(
            0 => 'Select Functionality',);
        foreach ($functionality_list as $functionality) {
            $functionality->id = $functionality->name;

            array_push($functionality_options, $functionality->id);
        }

        $industry_list = $this->get_industry();
        $industry_options = array(
            0 => 'Select Industry');
        foreach ($industry_list as $industry) {
            $industry->id = $industry->name;

            array_push($industry_options, $industry->id);
        }

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'first_name' => array("name" => "first_name",
                "type" => "text",
                "id" => "first_name",
                "class" => "form-control",
                "placeholder" => "First Name",
                "validate" => 'required',
                "error" => 'First Name',
                "value" => set_value('first_name', (isset($arrResult->first_name) ? $arrResult->first_name : '')),
            ),
            'last_name' => array("name" => "last_name", "type" => "text",
                "id" => "last_name",
                "class" => "form-control",
                "placeholder" => "Last Name",
                "validate" => 'required',
                "error" => 'Last Name',
                "value" => set_value('last_name', (isset($arrResult->last_name) ? $arrResult->last_name : '')),
            ),
            'email' => array("name" => "email", "type" => "text",
                "id" => "email",
                "class" => "form-control",
                "placeholder" => "Email",
                "validate" => 'required|valid_email',
                "error" => 'Email',
                "value" => set_value('email', (isset($arrResult->email) ? $arrResult->email : '')),
            ),
            'username' => array("name" => "username", "type" => "text",
                "id" => "username",
                "class" => "form-control",
                "placeholder" => "Username",
                "placeholder" => "Email",
                "validate" => 'required',
                "error" => 'Username',
                "value" => set_value('username', (isset($arrResult->username) ? $arrResult->username : '')),
            ),
            'password' => array("name" => "password",
                "type" => "password",
                "id" => "password",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Password',
                "placeholder" => "Password",
            //"value"=>set_value('password', (isset($arrResult->password) ? $arrResult->password : '')),
            ),
            'cpassword' => array("name" => "cpassword",
                "type" => "password",
                "id" => "cpassword",
                "class" => "form-control",
                "validate" => 'required|matches[password]',
                "error" => 'Confirm Password',
                "placeholder" => "Confirm Password",
            //"value"=>$this->input->post("cpassword")
            ),
            'industry' => array("name" => "industry_id",
                "type" => "dropdown",
                "id" => "industry_id",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Industry',
                "placeholder" => "Industry",
                "options" => $industry_options,
                "value" => set_value('googleplus', (isset($arrResult->industry_id) ? $arrResult->industry_id : '')),
            ),
            'functionality' => array("name" => "functionality_id",
                "type" => "dropdown",
                "id" => "functionality_id",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Functionality',
                "placeholder" => "Functionality",
                "options" => $functionality_options,
                "value" => set_value('googleplus', (isset($arrResult->functionality_id) ? $arrResult->functionality_id : '')),
            ),
            'linkden' => array("name" => "linkden",
                "type" => "text",
                "id" => "linkden",
                "class" => "form-control",
                "validate" => 'required|trim|prep_url|valid_url|xss_clean',
                "error" => 'Linkedin URL',
                "placeholder" => "Linkedin URL",
                "value" => set_value('linkden', (isset($arrResult->linkden) ? $arrResult->linkden : '')),
            ),
            'facebook' => array("name" => "facebook",
                "type" => "text",
                "id" => "facebook",
                "class" => "form-control",
                "validate" => 'required|trim|prep_url|valid_url|xss_clean',
                "error" => 'Facebook URL',
                "placeholder" => "Facebook URL",
                "value" => set_value('facebook', (isset($arrResult->facebook) ? $arrResult->facebook : '')),
            ),
            'twitter' => array("name" => "twitter",
                "type" => "text",
                "id" => "twitter",
                "class" => "form-control",
                "validate" => 'required|trim|prep_url|valid_url|xss_clean',
                "error" => 'Twitter URL',
                "placeholder" => "Twitter URL",
                "value" => set_value('twitter', (isset($arrResult->twitter) ? $arrResult->twitter : '')),
            ),
            'googleplus' => array("name" => "googleplus",
                "type" => "text",
                "id" => "googleplus",
                "class" => "form-control",
                "validate" => 'required|trim|prep_url|valid_url|xss_clean',
                "error" => 'GooglePlus URL',
                "placeholder" => "GooglePlus URL",
                "value" => set_value('googleplus', (isset($arrResult->googleplus) ? $arrResult->googleplus : '')),
            ),
            'company_name' => array("name" => "company_name",
                "type" => "text",
                "id" => "company_name",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Company Name',
                "placeholder" => "Company Name",
                "value" => set_value('company_name', (isset($arrResult->company_name) ? $arrResult->company_name : '')),
            ),
            'designation' => array("name" => "designation",
                "type" => "text",
                "id" => "designation",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Designation',
                "placeholder" => "Designation",
                "value" => set_value('designation', (isset($arrResult->designation) ? $arrResult->designation : '')),
            ),
            'phone' => array("name" => "phone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Phone',
                "placeholder" => "Phone",
                "value" => set_value('phone', (isset($arrResult->phone) ? $arrResult->phone : '')),
            ),
            'phone' => array("name" => "phone",
                "type" => "text",
                "id" => "phone",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Phone',
                "placeholder" => "Phone",
                "value" => set_value('phone', (isset($arrResult->phone) ? $arrResult->phone : '')),
            ),
            'mobile' => array("name" => "mobile",
                "type" => "text",
                "id" => "mobile",
                "class" => "form-control",
                "validate" => 'required',
                "error" => 'Mobile',
                "placeholder" => "Mobile",
                "value" => set_value('mobile', (isset($arrResult->mobile) ? $arrResult->mobile : '')),
            ),
        );
        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/user/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/user/add';
        }
        $arrData['fileUpload'] = false;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * generate_login_fields
     *
     * generates form field elements
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  null
     * @return  void
     */
    function generate_login_fields() {

        $arrResult = array();

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'username' => array("name" => "username",
                "type" => "text",
                "id" => "username",
                "class" => "form-control uname",
                "placeholder" => "Username",
                "validate" => 'required',
                "error" => 'Mobile Number',
                "value" => set_value('username'),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                ),
            ),
            'password' => array("name" => "password",
                "type" => "password",
                "id" => "password",
                "class" => "form-control pword",
                "placeholder" => "Password",
                "validate" => 'required|',
                "error" => 'Password',
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "",
                        "position" => "appendOuter",
                        "content" => '<a href="' . base_url('manage/login/forgot_password') . '"><small>Forgot Your Password?</small></a>'
                    )
                ),
            ),
        );

        $arrData['action'] = '';
        $arrData['fileUpload'] = false;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'login', 'role' => 'form');
        return $arrData;
    }

    /**
     * generate_forgot_fields
     *
     * generates form field elements
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  null
     * @return  void
     */
    function generate_forgot_fields() {

        $arrResult = array();

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'username' => array("name" => "username",
                "type" => "text",
                "id" => "username",
                "class" => "form-control",
                "placeholder" => "Username",
                "validate" => 'required',
                "error" => 'Username',
                "value" => set_value('username'),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                ),
            ),
        );

        $arrData['action'] = '';
        $arrData['fileUpload'] = false;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'login', 'role' => 'form');
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves user
     * 
     * @author  Aatish Gore 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAll($data, $id = NULL) {
        $error = FALSE;
        try {
            $user_id = $this->save($data, $id);
            $data['user_id'] = $user_id;
        } catch (Exception $e) {
            $error = true;
        }

        if ($error) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return !$error;
    }

    /**
     * save
     *
     * saves user
     * 
     * @author  Aatish Gore 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function save($data, $id = NULL) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
        //check if user exist

        if (!is_null($id)) {
            unset($arrData['email']);
            unset($arrData['username']);
        }
        $this->db->start_cache();
        if (isset($arrData['email']) && is_null($id)) {

            $id = $this->inner_check($arrData['email']);
        }
        if (!$id) {
            $id = NULL;
        }
        if (is_null($id)) {
            if (isset($arrData['username'])) {
                $id = $this->inner_check($arrData['username']);
            }
        }
        $this->db->stop_cache();
        $this->db->flush_cache();
        if (!$id) {
            $id = NULL;
        }


        if (!isset($arrData['status']))
            $arrData['status'] = 1;
        if (isset($arrData['password']))
            $arrData['password'] = md5($arrData['password']);
        $this->db->flush_cache();
        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();
            $result = $this->db->insert('user', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('user', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

    /**
     * check_email
     *
     * checks email
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  $email
     * @return  void
     */
    function check_email($email) {
        $this->db->select('email', $email);
        $query = $this->db->get('user');
        $result = $query->result();
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * check_user
     *
     * checks if user exist
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  $email
     * @return  void
     */
    function check_user($search, $field = 'email') {
        $this->db->select('id, email');
        $this->db->where($field, $search);
        $result = $this->db->get('user')->row();
        $this->db->where($field . ' IS NOT NULL');
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function inner_check($search, $field = 'email') {
        $this->db->select('id');
        $this->db->where($field, $search);
        $this->db->where($field . ' IS NOT NULL');
        $result = $this->db->get('user')->row();

        if ($result) {
            return $result->id;
        } else {
            return FALSE;
        }
    }

    /**
     * get
     *
     * gets user
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get($id = NULL, $row = FALSE) {

        $this->db->where('user.id', $id);
        if ($row) {

            $this->db->join('user_has_industry', 'user_has_industry.user_id = user.id');
            $this->db->join('user_has_functionality', 'user_has_functionality.user_id = user.id');
            $result = $this->db->get('user')->row();
            //echo '<pre>'; print_r($result->result()); exit;
            return $result;
        } else {
            $this->db->join('user_has_industry', 'user_has_industry.user_id = user.id');
            $this->db->join('user_has_functionality', 'user_has_functionality.user_id = user.id');
            $result = $this->db->get('user');
            //echo '<pre>'; print_r($result->result()); exit;
            return $result->result_array();
        }
    }

    /**
     * get_functionality
     *
     * gets functionality list
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get_functionality() {
        $this->db->where('status', 1);
        $query = $this->db->get('functionality');
        $result = $query->result();
        return $result;
    }

    /**
     * get_industry
     *
     * gets industry list
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get_industry() {
        $this->db->where('status', 1);
        $query = $this->db->get('industry');
        $result = $query->result();
        return $result;
    }

    function list_users() {

        $this->db->where('status', 1);
        $query = $this->db->get('user');
        $result = $query->result();
        return $result;
    }

    function authenticate($arrData = array()) {
        if (empty($arrData))
            return false;
        $this->db->select('id as user_id,first_name,last_name,email,username,type_of_user,top_level_id,is_superadmin');
        $email = $username = $arrData['username'];
        $password = md5($arrData['password']);
        $this->db->where("(username = '$username' and password = '$password') OR (email='$username' and password = '$password')");
        $objResult = $this->db->get('user')->row();
        $arrResult = (array) $objResult;
        if ($this->createUserSession($arrResult)) {
            
            setcookie('logged_in_type', $objResult->type_of_user, time() + 86400, '/');
            setcookie('logged_in_id', $objResult->user_id, time() + 86400, '/');
            setcookie('menu_name', 'Dashboard', time() + 86400, '/');

            return true;
        }
        else
            return false;
    }

    function adminLogin($arrData = array()) {
        if (empty($arrData))
            return false;
        $this->db->select('id as user_id,first_name,last_name,email,username,type_of_user,top_level_id,is_superadmin');
        $id = $username = $arrData['id'];
        $type_of_user = ($arrData['type_of_user']);
        $this->db->where("(id = '$id' and type_of_user = '$type_of_user')");
        $objResult = $this->db->get('user')->row();
        $arrResult = (array) $objResult;
        print_r($arrResult);
        if ($this->createUserSession($arrResult)) {
            return true;
        } else {
            return false;
        }
    }

    function createUserSession($arrData = array()) {
        if (empty($arrData))
            return false;
        $type = $arrData['type_of_user'];
        switch ($type) {
            case 'O':
                $objOrg = $this->organizer_model->getAll($arrData['user_id'], true, NULL, array(), 'user_id');
                $arrData['id'] = $objOrg->organizer_id;
                $arrData['event_id'] = $objOrg->event_id;
                $arrData['logo'] = base_url() . 'public/admin/images/user.png';
                break;
            case 'E':
                $objExh = $this->exhibitor_model->getAll($arrData['user_id'], true, NULL, array(), 'exhibitor.user_id');
                $arrData['id'] = $objExh->exhibitor_id;
                $arrData['event_id'] = $objExh->event_id;
                $arrData['logo'] = ($objExh->logo != '') ? base_url . UPLOAD_EXHIBITOR_LOGO_DISPLAY . $objExh->logo : base_url() . 'public/admin/images/user.png';
                break;
        }
//        echo '<pre>';print_r($objExh);exit;
        $this->session->set_userdata($arrData);
        return true;
    }

    function forgot_password($data = array()) {
        if (empty($data))
            return false;
        $arrResult = array();
        $result = $this->check_user($data['username']);
        if ($result->email) {

            $password = generatePassword(6);
            $subject = 'Password Changed';
            $message = "Hello,<br/>";
            $message .= "We have received a request to reset the password for this e-mail address. <br/>";
            $message .= "Find below your credentials to login to the Admin panel and manage your event:<br/>";
            $message .= "Event Name: <br/>";
            $message .= "Username:" . $data['username'] . "<br/>";
            $message .= 'Password:' . $password . "<br/>";
            $message .= 'If you did not request to reset your password for this ID, kindly ignore this email.<br/>';
            $message .= 'Team Procialize';

            if (sendMail($result->email, $subject, $message)) {
                $arrResult['password'] = ($password);
                $this->save($arrResult, $result->id);
                return true;
            } else {
                return false;
            }
//        $arrData['password'] = 
        } else {
            $this->session->set_flashdata('message', 'Please Contact Site Admin');
            redirect('manage/login/forgot_password');
        }
    }

}

?>