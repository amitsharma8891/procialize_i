<?php

class Tag extends CI_Controller {

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
        $this->load->model('tag_model', 'model');
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
        $this->model->order_name = 'tag.tag_name';

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        }

        $arrData['list'] = $this->model->get();
        //echo '<pre>'; print_r($arrData); exit;
        if ($this->input->post()) {
            if ($this->input->post('delete')) {
                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Tag Deleted Successfully.');
                    redirect('manage/tag');
                } else {
                    $this->session->set_flashdata('message', 'Fail to Delete Tag');
                    redirect('manage/tag');
                }
            }
            if ($this->input->post('search') != '') {
                $search = $this->input->post('search');
                $field = array("tag.tag_name", "tag_name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
                
            }
            
        }

        $arrData['fields'] = $this->model->generate_fields();
        $arrData['thisPage'] = 'Default Tag';
        $arrData['breadcrumb'] = 'Tag';
        $arrData['middle'] = 'admin/tag/index';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * autocomplete
     *
     * This displays  content
     * 
     * @author	Aatish Gore
     * @access	public
     * @params	null
     * @return	void
     */
    public function autocomplete() {
        $arrTags = array();
        $Tags = array();
        $search = $_GET['term'];
        if ($search != '') {
            $this->model->status = 1;
            $arrTags = $this->model->search($search);
            $i = 0;
            foreach ($arrTags as $tag) {
                $Tags[$i]['id'] = $tag['id'];
                $Tags[$i]['label'] = $tag['tag_name'];
                $Tags[$i]['value'] = $tag['tag_name'];
                $i++;
            }
        }
        echo json_encode($Tags);

        exit;
    }

    /**
     * add
     *
     * add content
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    function add($id = '') {

        $arrData['fields'] = $this->model->generate_fields();
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert = $this->input->post();
                unset($arrInsert['btnSave']);
                //unset($arrInsert['cpassword']);
                //$arrInsert['top_level_id'] = getTopLevelId();          ;
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");

                $status = $this->model->save($arrInsert);
                if ($status) {
                    $this->session->set_flashdata('message', 'Tag Added Successfully !!');
                    redirect('manage/tag');
                } else {
                    $this->session->set_flashdata('message', 'Failed to add Tag.');
                    redirect('manage/tag/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Tag';
        $arrData['breadcrumb'] = 'Tag';
        $arrData['middle'] = 'admin/tag/add';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * edit
     *
     * edit Tag
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    public function edit($id = NULL) {
        // echo $id; exit;
        $arrData['fields'] = $this->model->generate_fields($id);
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrUpdate = $this->input->post();
                unset($arrUpdate['btnSave']);

                $arrUpdate['modified_by'] = getCreatedUserId();
                $arrUpdate['modified_date'] = date("Y-m-d H:i:s");
                //echo '<pre>'; print_r($arrUpdate); exit;
                $status = $this->model->save($arrUpdate, $id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Tag Edited Successfully !!');
                    redirect('manage/tag');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Edit Tag!!');
                    redirect('manage/tag/edit/' . $id);
                }
            }
        }
        $arrData['thisPage'] = 'Default Tag';
        $arrData['breadcrumb'] = 'Tag';
        $arrData['middle'] = 'admin/middle_template';
        $this->load->view('admin/default', $arrData);
    }

    function delete($json = 'noJson') {
        $arrResult = array();

        if ($this->input->post('id')) {
            $status = $this->model->delete($this->input->post('id'));
            if ($status) {
                $arrResult['status'] = TRUE;
                $arrResult['message'] = 'Tag Deleted Successfully.';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Failed to Delete Tag.';
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