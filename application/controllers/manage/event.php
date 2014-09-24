<?php

class Event extends CI_Controller {

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
        $this->load->model('event_model', 'model');
        $this->load->model('industry_model');
        $this->load->model('functionality_model');
        $this->load->model('event_profile_model');
        $this->load->model('tag_relation_model');
        $this->load->model('tag_model');
        $this->load->model('has_model');
        $this->load->model('organizer_model');
        $this->load->model('user_model');
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

        $type = $this->session->userdata('type_of_user');
        $superadmin = $this->session->userdata('is_superadmin');

        if ($type == 'O' && !$superadmin)
            redirect('manage/index');

        $this->model->status = array("0", "1");
        $this->model->order_name = 'event.name';

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'event.id';
            $this->model->order_by = 'DESC';
        }

        $arrData['list'] = $this->model->getAll();
        if ($this->input->post()) {
            if ($this->input->post('delete')) {
//                print_r($this->input->post('delete'));exit;
                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Event Profile Deleted');
                    redirect('manage/event');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Event Profile');
                    redirect('manage/event');
                }
            }
            if ($this->input->post('Search') != '') {

                $search = $this->input->post('Search');
                $field = array("event.name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
//                echo $this->db->last_query();exit;
            }

            if ($this->input->post('organizer_drpdown') != '' && $this->input->post('Search') == '') {
                $search = $this->input->post('organizer_drpdown');
                $field = array("event.organizer_id");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND');
            }
        }

        $arrData['Organizer_dropdown'] = $this->organizer_model->getDropdownValues();
//        echo '<pre>';print_r($arrData);exit;
        $arrData['thisPage'] = 'Default Event';
        $arrData['breadcrumb'] = ' Event Profile';
        $arrData['breadcrumb_tag'] = ' Description for event goes here';
        $arrData['breadcrumb_class'] = 'fa-home';


//        echo '<pre>';print_r($arrData);exit;
        $arrData['middle'] = 'admin/event/index';
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
    function add() {

        $arrData['fields'] = $fields = $this->model->generate_fields();


        $type = $this->session->userdata('type_of_user');

        if ($type == 'E') {
            unset($fields['organizer']);
            unset($arrData['fields']['organizer']);
        }
        if ($this->input->post()) {
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);

            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {

                $event = $arrInsert['name'];

                if ($_FILES['logo']['name'] != '' || $_FILES['floor_plan']['name'] != '' || $_FILES['image1']['name'] != '' || $_FILES['image2']['name'] != '' || $_FILES['image3']['name'] != '') {
                    $upload_status = $this->model->savePhoto($arrInsert, $fields);
                    if (!$upload_status) {
                        $this->session->set_flashdata('message', $arrInsert[0]);
                        redirect('manage/event/edit/' . $id);
                    }
                }
                $check_unique = $this->model->check_unique($event);
                //echo $check_unique; exit;
                if (!$check_unique) {
                    $this->session->set_flashdata('message', 'Event Profile with same name found !!');
                    redirect('manage/event');
                } else {

                    $upload_status = $this->model->savePhoto($arrInsert, $fields);
                    if (!$upload_status) {
                        $this->session->set_flashdata('message', $arrInsert[0]);
                        redirect('manage/event/add');
                    }
                    unset($arrInsert['btnSave']);
                    unset($arrInsert['cpassword']);
                    $arrInsert['pvt_org_id'] = getPrivateOrgId();
                    $arrInsert['created_by'] = getCreatedUserId();
                    $arrInsert['created_date'] = date("Y-m-d H:i:s");
                    //                echo '<pre>';print_r($arrInsert);exit;
                    $status = $this->model->saveAll($arrInsert);
                    if ($status) {
                        $this->session->set_flashdata('message', 'Event Profile Added Successfully !!');
                        redirect('manage/event');
                    } else {
                        $this->session->set_flashdata('message', 'Failed to Add Event Profile!!');
                        redirect('manage/event/add');
                    }
                }
            }
        }
        $arrData['thisPage'] = 'Default Event';
        $arrData['breadcrumb'] = 'Create Event';
        $arrData['event_page'] = 'event';
        $arrData['breadcrumb_tag'] = ' All elements to add an Event...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/event/add';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * edit
     *
     * edit exhibitors
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    public function edit($id = NULL) {
        //echo $id; exit;
        $superadmin = $this->session->userdata('is_superadmin');
        $arrData['fields'] = $fields = $this->model->generate_fields($id);
        $arrData['fields']['fields']['name']['validate'] = 'required';
        if (getTypeUser() == 'O' && !$superadmin) {
            unset($arrData['fields']['fields']['organizer']);
            unset($arrData['fields']['fields']['is_featured']);
            $arrData['fields']['fields']['event_start']['id'] = 'event_start';
            $arrData['fields']['fields']['event_end']['id'] = 'event_end';
        }
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === true) {
                $arrInsert = $this->input->post();
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);

                if ($_FILES['logo']['name'] != '' || $_FILES['floor_plan']['name'] != '' || $_FILES['image1']['name'] != '' || $_FILES['image2']['name'] != '' || $_FILES['image3']['name'] != '') {
                    $upload_status = $this->model->savePhoto($arrInsert, $fields);
                    //echo "<pre>"; print_r($fields['fields']);  exit;
                    if (!$upload_status) {
                        $this->session->set_flashdata('message', $arrInsert[0]);
                        redirect('manage/event/edit/' . $id);
                    }
                }
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['pvt_org_id'] = getPrivateOrgId();
                $arrInsert['modified_by'] = getCreatedUserId();
                $arrInsert['modified_date'] = date("Y-m-d H:i:s");
                //echo "<pre>"; print_r($arrInsert); exit;
                $status = $this->model->saveAll($arrInsert, $id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Event Profile Updated Successfully !!');
                    redirect('manage/event');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Update Event Profile!!');
                    redirect('manage/event/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Event';
        $arrData['breadcrumb'] = 'Edit Event';
        $arrData['event_page'] = 'event';
        $arrData['datepicker'] = 'false';
        $arrData['breadcrumb_tag'] = ' Description for event goes here';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/event/add';//'admin/middle_template';
        $arrData['data'] = $this->model->getAll($id, true);
        // echo '<pre>';print_r($arrData); exit;
        $this->load->view('admin/default', $arrData);
    }

    function delete($json = 'noJson') {

        $arrResult = array();

        if ($this->input->post('id')) {
            $status = $this->model->delete($this->input->post('id'));

            if ($status) {
                $arrResult['status'] = TRUE;
                $arrResult['message'] = 'Event Profile Deleted';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Event Profile not Deleted';
            }
            if ($status == 'AEx') {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Event can not be deleted as there are active Exhibitors / Attendees associated with it';
            }
            if ($status == 'AAt') {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Event can not be deleted as there are active Attendees associated with it';
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
