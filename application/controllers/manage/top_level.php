<?php

class Top_level extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Aatish Gore
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('top_level_model', 'model');
    }

    /**
     * index
     *
     * This displays  content
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    public function index($order = 0) {
//        print_r($this->session->all_userdata());exit;
        $this->model->status = array("0", "1");
        $this->model->order_name = 'top_level.name';

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        }

        $arrData['list'] = $this->model->getAll();
        //echo '<pre>'; print_r($arrData); exit;
        if ($this->input->post()) {
            if ($this->input->post('delete')) {
                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Top Level Deleted Successfully');
                    redirect('manage/industry');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Top Level');
                    redirect('manage/industry');
                }
            }
            if ($this->input->post('search') != '') {

                $search = $this->input->post('search');

                $field = array("top_level.name", "name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
                
            }
            
        }
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Top Level';
        $arrData['middle'] = 'admin/top_level/index';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * add
     *
     * add content
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    public function add() {

        $arrData['fields'] = $this->model->generate_fields();
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert = $this->input->post();
                unset($arrInsert['btnSave']);
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $status = $this->model->save($arrInsert);
                if ($status) {
                    $this->session->set_flashdata('message', 'Top Level Added Successfully !!');
                    redirect('manage/top_level/index');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add Top Level!!');
                    redirect('manage/top_level/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Top Level';
        $arrData['middle'] = 'admin/middle_template';
        $this->load->view('admin/default', $arrData);
    }




   /**
     * edit
     *
     * edit top level
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    public function edit($id = NULL) {

        $arrData['fields'] = $this->model->generate_fields($id);
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrUpdate = $this->input->post();
                unset($arrUpdate['btnSave']);
                $arrUpdate['modified_by'] = getCreatedUserId();
                $arrUpdate['modified_date'] = date("Y-m-d H:i:s");
                
                $status = $this->model->save($arrUpdate,$id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Top Level Edited Successfully !!');
                    redirect('manage/top_level/index');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Edit Top Level!!');
                    redirect('manage/top_level/edit/'.$id);
                }
            }
        }
        $arrData['thisPage'] = 'Default Organizer';  
        $arrData['breadcrumb'] = 'Top Level';
        $arrData['middle'] = 'admin/middle_template';
        $this->load->view('admin/default', $arrData);
    }

    function delete($json = 'noJson') {
        $arrResult = array();

        if ($this->input->post('id')) {
            $status = $this->model->delete($this->input->post('id'));
            if ($status) {
                $arrResult['status'] = TRUE;
                $arrResult['message'] = 'Top Level Deleted Successfully.';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Failed to Delete Top Level.';
            }
        }
        if ($json = 'json') {
            echo json_encode($arrResult);
            exit;
        }
    }


}

/* End of file top_level.php */
/* Location: ./application/controllers/admin/top_level.php */