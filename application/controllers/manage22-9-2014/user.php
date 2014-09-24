<?php

class User extends CI_Controller {

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
        $this->load->model('user_model', 'model');
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
    public function index() {
        //$arrData['fields'] = $this->model->generate_fields();

        $arrData['list'] = $this->model->list_users();
        //echo '<pre>'; print_r($arrData['list']); exit;
        $arrData['thisPage'] = 'Default User';
        $arrData['breadcrumb'] = 'User';
        $arrData['breadcrumb_tag'] = ' All elements of an User..';
        $arrData['breadcrumb_class'] = 'fa-flask';

        $arrData['middle'] = 'admin/user/list';
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
                unset($arrInsert['cpassword']);
                $arrInsert['top_level_id'] = getTopLevelId();
                ;
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");

                $status = $this->model->save($arrInsert);
                if ($status) {
                    $this->session->set_flashdata('message', 'User Added Successfully !!');
                    redirect('manage/user');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add User!!');
                    redirect('manage/user/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default User';
        $arrData['breadcrumb'] = 'User';
        $arrData['breadcrumb_tag'] = ' All elements add an an User..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/user/add';
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
                unset($arrUpdate['cpassword']);
                $arrUpdate['top_level_id'] = getTopLevelId();
                $arrUpdate['modified_by'] = getCreatedUserId();
                $arrUpdate['modified_date'] = date("Y-m-d H:i:s");
                $status = $this->model->save($arrUpdate, $id);
                if ($status) {
                    $this->session->set_flashdata('message', 'User Edited Successfully !!');
                    redirect('manage/user');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Edit User!!');
                    redirect('manage/user/edit/' . $id);
                }
            }
        }
        $arrData['thisPage'] = 'Default User';
        $arrData['breadcrumb'] = 'User';
        $arrData['breadcrumb_tag'] = ' All elements edit an an User..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/middle_template';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * edit prifile
     *
     * edit user
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    function edit_profile($id = NULL) {
        $is_superadmin = $this->session->userdata('is_superadmin');
        $user_id = $this->session->userdata('user_id');
        $type_of_user = $this->session->userdata('type_of_user');
        if (!$is_superadmin) {
            if ($type_of_user == 'O') {
                $this->db->select('id');
                $this->db->where_in('organizer.user_id', $user_id);
                $arrData = $this->db->get('organizer')->row();
                if ($arrData->id) {
                    redirect('manage/organizer/add_edit/' . $arrData->id);
                } else {
                    redirect('manage/index');
                }
            } else {
                redirect('manage/index');
            }
        }
        $arrData['thisPage'] = 'Default Organizer';
        if ($id) {
            $arrData['breadcrumb'] = 'Edit Profile';
        } else {
            $arrData['breadcrumb'] = 'Edit Profile';
        }
        $arrData['breadcrumb_tag'] = ' All elements to edit an Organizer...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/user/edit_profile';

        $is_superadmin = $this->session->userdata('is_superadmin');
        if ($id || $is_superadmin) {
            if ($is_superadmin && empty($id)) {
                $superadmin_user_id = $this->session->userdata('user_id');
                $this->db->where_in('user.id', $superadmin_user_id);
            } else {
                $this->db->where_in('user.id', $id);
            }
//            $this->db->join('user', 'user.id = organizer.user_id');
            $arrData['list'] = $this->db->get('user')->row();
        }
//        $arrData['list'] = $this->model->get($id, 1);
        $this->load->view('admin/default', $arrData);
    }

    /**
     * edit prifile
     *
     * edit user
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    function validate_user() {
        $arrInsert = $this->input->post(NULL, TRUE);
        if (empty($arrInsert['user_id'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');
            $arrInsert['password'] = md5($arrInsert['password']);
        } else {
            $email_result = $this->check_email_exist($arrInsert['user_id'], $this->input->post('email'));
            if (!$email_result) {
                $json_array['email'] = 'email_not_match';
                $json_array['error'] = 'error';
            } else {
                $json_array['email'] = 'email_match';
            }
            if (isset($arrInsert['password']) && !empty($arrInsert['password']) || isset($arrInsert['cpassword']) && !empty($arrInsert['cpassword']) || isset($arrInsert['current_password']) && !empty($arrInsert['current_password'])) {
                $this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]');
                $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');
                $this->form_validation->set_rules('current_password', 'Current Password', 'required');
                $curent_pass_result = $this->organizer_model->checkcurrentPass(md5($this->input->post('current_password')), $arrInsert['user_id']);
                if (!$curent_pass_result) {
                    $json_array['current_pass'] = 'not_match';
                    $json_array['error'] = 'error';
                } else {
                    $json_array['current_pass'] = 'match';
                }
            }
//            $this->form_validation->set_rules('email', 'Email', 'required');
        }
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        if ($this->form_validation->run() == False) {
            $json_array['error'] = 'error';
            $json_array['first_name_err'] = form_error('first_name');
            $json_array['username_err'] = form_error('username');
            $json_array['email_err'] = form_error('email');
            $json_array['password_err'] = form_error('password');
            $json_array['passconf_err'] = form_error('cpassword');
        } else {
            if ($this->input->post()) {
                if (!isset($json_array['current_pass']) || $json_array['current_pass'] == 'match') {
                    if ($json_array['email'] == 'email_match') {
                        $arrInsert = $this->input->post(NULL, TRUE);
                        $id = $this->input->post('user_id');
                        $arrInsert['created_by'] = getCreatedUserId();
                        $arrInsert['created_date'] = date("Y-m-d H:i:s");
                        $arrInsert['top_level_id'] = '1';
                        $arrInsert['pvt_org_id'] = '1';
                        $arrInsert['type_of_user'] = 'O';
                        unset($arrInsert['current_password']);
                        $status = $this->model->edit_profile($id, $arrInsert);
                        $json_array['error'] = 'success';
                    }
                }
            }
        }
        echo json_encode($json_array);
    }

    /**
     * edit prifile
     *
     * edit user
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    function check_email_exist($id, $email) {

        $this->db->select('email');
        $this->db->where_in('user.id', $id);
        $resultdata = $this->db->get('user')->row();
        if ($resultdata->email == $email) {
            return 1;
        } else {
            return 0;
        }
    }

}

/* End of file top_level.php */
/* Location: ./application/controllers/admin/top_level.php */