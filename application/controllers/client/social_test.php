<?php

class Social_test extends CI_Controller {

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
        //$this->session->set_userdata( array('event_reffaral' => $_SERVER['REQUEST_URI']));
        $this->load->model('client/client_event_model','model');
    }

    function fb_login()
    {
        
    }
    
    function linkdin_login()
    {
        $data                                                                   = array();
        $this->load->view('client/social/linkedin',$data);
    }
}