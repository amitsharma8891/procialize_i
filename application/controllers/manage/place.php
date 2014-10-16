<?php

class Place extends CI_Controller {

    public $superadmin = false;

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Anupam
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('place_model', 'model');
        $this->superadmin = $this->session->userdata('is_superadmin');
    }

    /**
     * index
     *
     * This displays  content
     * 
     * @author	Anupam
     * @access	public
     * @params	null
     * @return	void
     */
    public function index($country_city_type = NULL) {
        if (!empty($country_city_type)) {
            $this->session->set_userdata('country_city_type', $country_city_type);
        }
        $country_city_type = $this->session->userdata('country_city_type');
        setcookie("postarray", "", time() - 3600);
        $this->model->status = array("0", "1");
        $this->model->name = $country_city_type . '.name';
        $search = "";
        $field = "";
        $arrData['list'] = $this->model->getAll($country_city_type, NULL, FALSE, $search, $field, $country_city_type . '.id', 'AND');
        $arrData['country_city_type'] = $country_city_type;
        $arrData['thisPage'] = 'Default ' . $country_city_type;
        $arrData['breadcrumb'] = ucfirst($country_city_type);
        $arrData['breadcrumb_tag'] = ' Description for ' . ucfirst($country_city_type) . ' goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $arrData['middle'] = 'admin/place/index';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * add
     *
     * add content
     * 
     * @author  Anupam
     * @access  public
     * @params  null
     * @return  void
     */
    function add($id = NULL) {
        $country_city_type = $this->session->userdata('country_city_type');
//        $this->form_validation->set_message('is_unique', 'This Email Template already exists. Please enter unique Email Template name');
        if ($this->input->post()) {
//            formVaidation($arrData['fields'], $this);
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);
            if ($this->form_validation->run() === TRUE) {
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $status = $this->model->saveAll($country_city_type, $arrInsert, $id);
                if ($status) {
                    $this->session->set_flashdata('message', ' Added ' . $country_city_type . ' Successfully !!');
                    redirect('manage/place');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add ' . $country_city_type . ' !!');
                    redirect('manage/place/add');
                }
            }
        }
        if ($country_city_type == 'city') {
            $arrData['country_list'] = $this->model->getAll('country');
        }
        $arrData['list'] = $this->model->get($country_city_type, $id);
        $arrData['country_city_type'] = $country_city_type;
        $arrData['thisPage'] = 'Default  ' . $country_city_type;
        $arrData['breadcrumb'] = 'Add  ' . ucfirst($country_city_type);
        $arrData['breadcrumb_tag'] = ' All elements to add ' . $country_city_type;
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/place/add';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * validate email template
     *
     * validate email template content
     * 
     * @author  Anupam
     * @access  public
     * @params  null
     * @return  void
     */
    function validate_place() {
        $country_city_type = $this->session->userdata('country_city_type');
        $this->load->library('form_validation');
        $arrInsert = $this->input->post();
        if (empty($arrInsert['place_id'])) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[' . $country_city_type . '.name]');
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required');
        }
        //print_r($this->input->post());

        if ($this->form_validation->run() == FALSE) {
            $json_array['error'] = 'error';
            $json_array['name_err'] = form_error('name');
        } else {
            $json_array['error'] = 'success';
            $arrInsert['created_by'] = getCreatedUserId();
            $arrInsert['created_date'] = date("Y-m-d H:i:s");
            if ($arrInsert['place_id']) {
                $status = $this->model->saveAll($country_city_type, $arrInsert, $arrInsert['place_id']);
            } else {
                $status = $this->model->saveAll($country_city_type, $arrInsert);
            }
        }

        echo json_encode($json_array);
    }

}
