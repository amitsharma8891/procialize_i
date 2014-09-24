<?php

class Login extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Login controller
     * @author		Amit  sharma
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('client/client_event_model','model');
    }

    function index()
    {
        $data                                                                   = array();
        echo $this->session->userdata('event_reffaral');
        //display($_SERVER);exit;
        $this->load->view(CLIENT_LOGIN_VIEW,$data);
    }
    
    
}