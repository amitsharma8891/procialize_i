<?php

class Ajax extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Ajax controller
     * @author		Aatish Gore
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function unique_user() {
        $arrData = array();
        if ($this->input->post('username')) {
            $username = $this->input->post('username');
            $check = $this->user_model->check_user($username, 'username');
            if (is_numeric($check)) {
                $arrData['status'] = TRUE;
                $arrData['message'] = 'Username Already exist';
            } else {
                $arrData['status'] = FALSE;
                $arrData['message'] = 'Username Avialable';
            }
        } else {
            $arrData['status'] = FALSE;
            $arrData['message'] = 'Invalid Request';
        }
        echo json_encode($arrData);exit;
    }

}