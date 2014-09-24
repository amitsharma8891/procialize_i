<?php

class Sponsor extends CI_Controller {

    public $event_id;

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

        $this->load->model('sponsor_model', 'model');
        $this->load->model('user_model');
        $this->load->model('event_model');

        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
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
        setcookie("postarray", "", time() - 3600);
        $this->model->status = array("0", "1");
        $this->model->order_name = 'sponser.name';

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'sponser.id';
            $this->model->order_by = 'DESC';
        }

        $arrData['list'] = $this->model->getAll();
        if ($this->input->post()) {
            if ($this->input->post('delete')) {

                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Sponsor Deleted Successfully');
                    redirect('manage/sponsor');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Sponsor');
                    redirect('manage/sponsor');
                }
            }


            if ($this->input->post('event_drpdown') != '' && $this->input->post('send_mail') == '') {
                $search = $this->input->post('event_drpdown');
                $field = array("sponser.event_id");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND');
//                echo $this->db->last_query();exit;
            }

            if ($this->input->post('search') != '') {

                $search = $this->input->post('search');
                $field = array("sponser.name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
                //echo '<pre>'; print_r($arrData); exit;
            }
        }
        setcookie("postarray", "", time() - 3600);

//        echo '<pre>';print_r($arrData);exit;
        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
        $arrData['thisPage'] = 'Default Sponsor';
        $arrData['breadcrumb'] = 'Sponsor';
        $arrData['breadcrumb_tag'] = ' Description for Sponsor goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $this->model->status = array("0", "1");
        $arrData['middle'] = 'admin/sponsor/index';
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
        //echo '<pre>'; print_r($_POST); exit;
        $message = '';
        $arrData['fields'] = $fields = $this->model->generate_fields();
        $superadmin = $this->session->userdata('is_superadmin');
//        if (!$superadmin) {
//            $splash_exist = $this->model->check_splash();
//            if ($splash_exist) {
//                unset($arrData['fields']['fields']['splash_ad']);
//                unset($fields['fields']['splash_ad']);
//            }
//        }
        if ($this->input->post()) {
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
//            if ($superadmin) {
//                $splash_exist = $this->model->check_splash($arrInsert['event_id']);
//                if ($splash_exist) {
//                    unset($arrData['fields']['fields']['splash_ad']);
//                    unset($fields['fields']['splash_ad']);
//                    $message = 'You can upload only one splash ad per event. ';
//                }
//            }
            $this->model->update_splash($arrInsert['event_id']);
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                setcookie('postarray', $postarray);
                unset($arrInsert['btnSave']);
                //unset($arrInsert['cpassword']);
                $company = $arrInsert['name'];
                $event_id = $arrInsert['event_id'];
                $check_unique = $this->model->check_unique($company, $event_id, $id = NULL);
                //echo $check_unique; exit;
                if ($check_unique) {
                    $this->session->set_flashdata('message', 'Sponsor with same Company name and Event found !!');
                    redirect('manage/sponsor');
                } else {
                    
                    $upload_status = $this->model->savePhoto($arrInsert, $fields);
                    //echo '==='.$upload_status; exit;
                    if (!$upload_status) {
                        //echo '1111'.$upload_status; exit;
                        $this->session->set_flashdata('message', $arrInsert[0]);
                        redirect('manage/sponsor/add');
                    }

                    $arrInsert['top_level_id'] = getTopLevelId();
                    $arrInsert['created_by'] = getCreatedUserId();
                    $arrInsert['created_date'] = date("Y-m-d H:i:s");

                    //echo '<pre>'; print_r($arrInsert); exit;
                    $status = $this->model->saveAll($arrInsert);
                    if ($status) {
                        $this->session->set_flashdata('message', $message . 'Sponsor Added Successfully !!');
                        redirect('manage/sponsor');
                    } else {
                        $this->session->set_flashdata('message', $message . 'Failed to Add Sponsor!!');
                        redirect('manage/sponsor/add');
                    }
                }
            }
        }
//        $arrData['thisPage'] = 'Default Exhibitor';
//        $arrData['breadcrumb'] = 'Exhibitor';
//        $arrData['middle'] = 'admin/exhibitor/add';
//        $arrData['middle'] = 'admin/middle_template';
//       
//        $this->load->view('admin/default',$arrData);
        $arrData['thisPage'] = 'Add Sponsor';
        $arrData['breadcrumb'] = 'Add Sponsor';
        $arrData['breadcrumb_tag'] = ' All elements to add an Sponsor..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/middle_template';
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
        // echo $id; exit;
        $message  = '';
        $superadmin = $this->session->userdata('is_superadmin');
        $arrData['fields'] = $fields = $this->model->generate_fields($id);
        unset($arrData['fields']['fields']['username']);
        unset($arrData['fields']['fields']['password']);
//        if (!$superadmin) {
//            $splash_exist = $this->model->check_splash($this->model->object->event_id, $this->model->object->id);
//            
//            if ($splash_exist) {
//                unset($arrData['fields']['fields']['splash_ad']);
//                unset($fields['fields']['splash_ad']);
//            }
//        }
        if ($this->input->post()) {
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);

//            if ($superadmin) {
//                if ($this->model->object->event_id == $arrInsert['event_id'])
//                    $sponser_id = $this->model->object->id;
//                else
//                    $sponser_id = NULL;
//                    $splash_exist = $this->model->check_splash($arrInsert['event_id'],$sponser_id);
//                if ($splash_exist) {
//                    unset($arrData['fields']['fields']['splash_ad']);
//                    unset($fields['fields']['splash_ad']);
//                    $message = 'You can upload only one splash ad per event. ';
//                }
//            }
            $this->model->update_splash($arrInsert['event_id']);
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {

                //echo '----<pre>'; print_r($_FILES); exit;
                unset($arrInsert['btnSave']);
                $company = $arrInsert['name'];
                $event_id = $arrInsert['event_id'];
                $check_unique = $this->model->check_unique($company, $event_id, $id);
                //echo $check_unique; exit;
                if ($check_unique) {
                    $this->session->set_flashdata('message', 'Sponsor with same Company name and Event found !!');
                    redirect('manage/sponsor');
                } else {
                    if ($_FILES['normal_ad']['name'] != '' || $_FILES['splash_ad']['name'] != '') {

                        $upload_status = $this->model->savePhoto($arrInsert, $fields);
                        if (!$upload_status) {
                            $this->session->set_flashdata('message', $arrInsert[0]);
                            redirect('manage/sponsor/edit/' . $id);
                        }
                    }


                    $status = $this->model->saveAll($arrInsert, $id);
                    if ($status) {
                        $this->session->set_flashdata('message', $message .'Sponsor Edited Successfully !!');
                        redirect('manage/sponsor');
                    } else {
                        $this->session->set_flashdata('message', 'Failed to Edit Sponsor!!');
                        redirect('manage/sponsor/edit/' . $id);
                    }
                }
            }
        }


        $arrData['thisPage'] = 'Default Sponsor';
        $arrData['breadcrumb'] = 'Edit Sponsor';
        $arrData['breadcrumb_tag'] = ' All elements to edit an Sponsor..';
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
                $arrResult['message'] = 'Sponsor Deleted Successfully';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Failed to Delete Sponsor';
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