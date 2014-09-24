<?php

class Email_template extends CI_Controller {

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
        $this->load->model('email_template_model', 'model');
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
    public function index($order = NULL) {
        setcookie("postarray", "", time() - 3600);
        $this->model->status = array("0", "1");
        $this->model->name = 'email_template.name';
        $search = "";
        $field = "";
        $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'email_template.id', 'AND');
        $arrData['thisPage'] = 'Default Email Template';
        $arrData['breadcrumb'] = ' Email Template';
        $arrData['breadcrumb_tag'] = ' Description for Email Template goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
//        $arrData['organizers'] = $this->model->getAll();
        $arrData['middle'] = 'admin/email_template/index';
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
        $this->form_validation->set_message('is_unique', 'This Email Template already exists. Please enter unique Email Template name');
        $arrData['fields'] = $fields = $this->model->generate_fields();
        $arrData['fields']['fields']['name']['validate'] = 'is_unique[email_template.name]';

        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);
            if ($this->form_validation->run() === TRUE) {
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $status = $this->model->saveAll($arrInsert, $id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Email Template Added Successfully !!');
                    redirect('manage/email_template');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add Email Template!!');
                    redirect('manage/email_template/add');
                }
            }
        }
        $result = $this->db->get('keywords_detail');
        $arrData['keyword_deatail'] = $result->result_array();
        $arrData['list'] = $this->model->get($id);
        $arrData['thisPage'] = 'Default Email Template';
        $arrData['breadcrumb'] = 'Add Email Template';
        $arrData['breadcrumb_tag'] = ' All elements to add an Organizer...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/email_template/add';
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
    function validate_email_template() {
        $this->load->library('form_validation');
        $arrInsert = $this->input->post();
        if (empty($arrInsert['email_id'])) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[email_template.name]');
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required');
        }
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        //print_r($this->input->post());

        if ($this->form_validation->run() == FALSE) {
            $json_array['error'] = 'error';
            $json_array['name_err'] = form_error('name');
            $json_array['subject_err'] = form_error('subject');
            $json_array['body_err'] = form_error('body');
        } else {
            $json_array['error'] = 'success';
            $arrInsert['created_by'] = getCreatedUserId();
            $arrInsert['created_date'] = date("Y-m-d H:i:s");
            $status = $this->model->saveAll($arrInsert);
        }

        echo json_encode($json_array);
    }

}
