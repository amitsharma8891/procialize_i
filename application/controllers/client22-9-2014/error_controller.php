<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class error_controller extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();	
        //$this->load->library('twig'); // load the Twig library
        $this->load->library('session');
    }
    function error()
    {
        if($this->session->flashdata('msg') != null || $this->session->flashdata('msg') != '')
        {
            $data['msg']                                                        = 'Sorry, required '.$this->session->flashdata('msg').' page is not found.';
        }
        else
        {
            $data['msg']                                                        = "Sorry, required page is not found.";
        }
        $this->load->view(CLIENT_404_ERROR_VIEW, $data);
    }
    function error_404()
    {
        $data['msg']                                                            = "Sorry, required page is not found.";
        $this->load->view(CLIENT_404_ERROR_VIEW, $data);
    }
    function error_db()
    {
        $data['msg']                                                            = "Sorry ther is database error.";
        $this->load->view(CLIENT_404_ERROR_VIEW, $data);
    }
}
