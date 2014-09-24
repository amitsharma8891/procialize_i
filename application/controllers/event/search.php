<?php
/**
 *
 * class Search
 *
 * Short desc	
 *
 * This class is required for Searching Events
 *
 * @author		Rima Mehta
 * @copyright		Copyright (c) 2014 - 2015 
 * @since               Version 1.0
 * 
**/
class Search extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model('event_model', 'model');
        $this->load->model('industry_model');
        $this->load->model('functionality_model');
    }

    /**
     * index
     *
     * This displays  search page
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    public function index($json='no') {

        $arrData['thisPage']    = 'Search an Event';
        $POST = array();
        
        if ($this->input->post())
            $POST = $_POST;
        
        $arrData['fields'] = $fields = $this->model->generate_search_fields_front($POST);
        
        if ($this->input->post()) {
            
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrData['searchResult'] = $this->model->get_search_result_front($_POST);
                
                
            }
        }
        
        
        //echo "<pre>";print_r($POST);
        
        //echo "<pre>";print_r($arrData);
        if($json == 'json'){
            echo json_encode($arrData);
            exit();
        }
        
        $arrData['middle'] = 'frontend/event/search';
           
        $this->load->view('frontend/event/default', $arrData);
        
    }

}

/* End of file top_level.php */
/* Location: ./application/controllers/event/search.php */