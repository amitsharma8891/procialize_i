<?php

class Home extends CI_Controller {

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
    }

    function welcome()
    {
        $this->load->view(CLIENT_WELCOME_VIEW);
        
    }
    
    function home_view()
    {
        $data                                                                   = array();
        $data['industry_list']                                                  = $this->model->getIndustry();
        $data['functionality_list']                                             = $this->model->getFunctionality();
        $this->load->view(CLIENT_HOME_VIEW,$data);
    }
    
    
}