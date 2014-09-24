<?php

class setting extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('setting_model', 'model');
    }

    public function index($order = 0) {
        $arrData['setting'] = json_decode($this->model->get_setting(),TRUE);
        //display(json_decode($arrData['setting'],TRUE));
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Setting';
        $arrData['middle'] = 'admin/setting/index';
        $this->load->view('admin/default', $arrData);
    }
    
    function validate_setting()
    {
        $this->load->library('form_validation');
        if($this->input->post())
        {
            foreach($this->input->post() as $k=>$v)
            {
                $this->form_validation->set_rules($k, 'This', 'required');
            } 
        }
		
        if ($this->form_validation->run() == FALSE)
        {
            $json_array['error'] = 'error';  
            if($this->input->post())
            {
                foreach($this->input->post() as $k1=>$v1)
                {
                    $json_array[$k1.'_err'] = form_error($k1);
                } 
            }
        }
        else
        {
            $data = $this->input->post(NULL,TRUE); 
            //$data['app_slider_image'] = $data['app_slider_image'];
            //display($data);
            $json_array['error'] = 'success'; 
            $save_data = $this->model->save_setting($data);
        }
        echo json_encode($json_array);
    }



}
