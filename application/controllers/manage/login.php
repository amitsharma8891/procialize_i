<?php

class Login extends CI_Controller {

    /**
     * Login Class
     *
     * @package	Procialize 
     * @subpackage	Login controller
     * @author		Aatish Gore
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'model');
    }

    function index() {
        $arrData['fields'] = $fields = $this->model->generate_login_fields();


        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert = $this->input->post();
                //echo '<pre>'; print_r($_POST); exit;
                unset($arrInsert['btnSave']);
//                echo $arrInsert['password'];
//                echo md5($arrInsert['password']);exit;
                $status = $this->model->authenticate($arrInsert);
                if ($status) {
                     $this->session->set_flashdata('show_popup', 'Yes');
                    redirect('manage/index');
                } else {
                    $this->session->set_flashdata('message', 'Incorrect Username or Password !!');
                    redirect('manage/login');
                }
            } else {
                $this->session->set_flashdata('message', 'Username or Password is required!!');
                redirect('manage/login');
            }
        }
        $this->load->view('admin/login', $arrData);
    }

    function forgot_password() {
        $arrData['fields'] = $fields = $this->model->generate_forgot_fields();
        formVaidation($arrData['fields'], $this);
        if ($this->form_validation->run() === TRUE) {
            $arrInsert = $this->input->post();
            unset($arrInsert['btnSave']);
            $status = $this->model->forgot_password($arrInsert);
            if ($status) {
                $this->session->set_flashdata('message', 'New Password has been sent on your mail');
                redirect('manage/login');
            } else {
                $this->session->set_flashdata('message', 'Fail to update your password');
                redirect('manage/login');
            }
        }
//        echo '<pre>';var_export($arrData['fields']);exit;
        $this->load->view('admin/forgot_password', $arrData);
    }

    function logout() {
		   setcookie("event_id", '', time() - 3600, '/');
         
        $this->session->sess_destroy();
        redirect('manage/login');
    }

    function adminLogin($type = NULL, $user_id = NULL) {
        $Usertype = $this->session->userdata('type_of_user');
		   setcookie("event_id", '', time() - 3600, '/');
         
        if ($this->session->userdata('is_superadmin') == 1 || ($Usertype == 'O' && $type == 'E') || ( get_cookie('logged_in_type') == 'E' || get_cookie('logged_in_type') == 'O' )) {
            if (!is_null($type) && !is_null($user_id)) {

//                $this->session->sess_destroy();
                
                $arrInsert['type_of_user'] = $type;
                $arrInsert['id'] = $user_id;
                $status = $this->model->adminLogin($arrInsert);
             // echo '<pre>';print_r($this->session->all_userdata());exit;
                redirect('manage/index');
            }
        }else{
//                die('asdf');
            redirect('manage/index');
        }
    }

}