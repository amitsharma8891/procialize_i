<?php

class Product_category extends CI_Controller {

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
        $this->load->model('product_category_model', 'model');
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
    public function index($order = NULL) {
//        print_r($this->session->all_userdata());exit;
        $this->model->status = array("0", "1");
        $this->model->order_name = 'product_category.name';

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'product_category.id';
            $this->model->order_by = 'DESC';
        }

        $arrData['list'] = $this->model->get();
        //echo '<pre>'; print_r($arrData); exit;
        if ($this->input->post()) {
            if ($this->input->post('delete')) {
                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Product Category Deleted Successfully');
                    redirect('manage/product_category');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Product Category');
                    redirect('manage/product_category');
                }
            }

            if ($this->input->post('search') != '') {
                $search = $this->input->post('search');
                $field = array("product_category.name", "name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
            }
        }



        $arrData['thisPage'] = 'Default Product Category';
        $arrData['breadcrumb'] = 'Product Category';
        $arrData['breadcrumb_tag'] = ' All elements to add an Product Category..';
        $arrData['breadcrumb_class'] = 'fa-flask';

        $arrData['middle'] = 'admin/product_category/index';
        $this->load->view('admin/default', $arrData);
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

                $id = NULL;
                $unique = $this->model->check_unique($arrInsert['name'], $id);
                //echo '<pre>'; print_r($unique); exit;
                if (!$unique) {
                    $this->session->set_flashdata('message', 'Product Category name already present.');
                    redirect('manage/product_category/add');
                }
                $status = $this->model->save($arrInsert);
                if ($status) {
                    $this->session->set_flashdata('message', 'Product Category Added Successfully !!');
                    redirect('manage/product_category');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add Product Category ');
                    redirect('manage/product_category/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Product Category';
        $arrData['breadcrumb'] = 'Product Category';
        $arrData['breadcrumb_tag'] = ' All elements to add an Product Category..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/product_category/add';

        $this->load->view('admin/default', $arrData);
    }

    /**
     * edit
     *
     * edit user
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

                $unique = $this->model->check_unique($arrUpdate['name'], $id);
//                echo '<pre>'; print_r($unique); exit;
                if ($unique) {
                    $this->session->set_flashdata('message', 'Product Category name already present.');
                    redirect('manage/product_category/');
                }

                $status = $this->model->save($arrUpdate, $id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Product Category Edited Successfully !!');
                    redirect('manage/product_category');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Edit Product Category.');
                    redirect('manage/product_category/edit/' . $id);
                }
            }
        }
        $arrData['thisPage'] = 'Default Product category';
        $arrData['breadcrumb'] = 'Product Category';
        $arrData['breadcrumb_tag'] = ' All elements to add an Product Category..';
        $arrData['breadcrumb_class'] = 'fa-flask';

        $arrData['middle'] = 'admin/middle_template';
        $this->load->view('admin/default', $arrData);
    }

    function delete($json = 'noJson') {
        $arrResult = array();

        if ($this->input->post('id')) {
            $status = $this->model->delete($this->input->post('id'));
            if ($status) {
                $arrResult['status'] = TRUE;
                $arrResult['message'] = 'Product Category Deleted Successfully.';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Failed to delete Product category.';
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