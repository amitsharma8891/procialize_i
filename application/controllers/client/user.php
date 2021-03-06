<?php

class User extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	User controller
     * @author		Amit  sharma
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('client/client_login_model', 'model');
        $this->load->model('place_model');
        $this->load->model('client/client_notification_model');
    }

    function profile_view($posted_data = NULL) {
        $user_id = $this->session->userdata('client_user_id');
        $attendee_id = $this->session->userdata('client_attendee_id');

        $data = array();
        if ($attendee_id) {
            $data['user_data'] = $this->model->getUserData($attendee_id);
            $search = $data['user_data']->country;
            $data['city_list'] = $this->place_model->getAll('city', NULL, NULL, $search, array('city.country_id'));
        }
        $data['country_list'] = $this->place_model->getAll('country');
        $data['industry_list'] = $this->model->getIndustry(NULL, NULL);
        $data['functionality_list'] = $this->model->getFunctionality(NULL, NULL);
//        echo "<pre>";print_r($data);
        if ($posted_data) {
            $this->load->view(CLIENT_USER_PROFILE_VIEW, $posted_data);
        } else {
            $this->load->view(CLIENT_USER_PROFILE_VIEW, $data);
        }
    }

    function login_view() {
        if ($this->session->userdata('client_user_id'))
            redirect(SITE_URL . 'events');
        if (get_cookie('email') && get_cookie('password')) {
            $check_login = $this->login(get_cookie('email'), get_cookie('password'));
            if ($check_login['error'] == 'success')
                redirect(SITE_URL . 'events');
        }
        $data = array();
        $this->load->view(CLIENT_LOGIN_VIEW, $data);
    }

    function save_user() {

        $config['upload_path'] = UPLOADS . 'attendee/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $config['quality'] = 100;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        $config['height'] = 200;
        $this->load->library('upload', $config);
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $post_data = $this->input->post();
        display($post_data);
        $user_id = $this->session->userdata('client_user_id');
        $attendee_id = $this->session->userdata('client_attendee_id');
        if ($attendee_id)
            $data['user_data'] = $this->model->getUserData($attendee_id);
//        $json_array['industry_list'] = $this->model->getIndustry(NULL, NULL);
//        $json_array['functionality_list'] = $this->model->getFunctionality(NULL, NULL);
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Worng!';


        if (!$attendee_id) {
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[conf_password]');
            $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required');
        }
        if ($attendee_id && $this->input->post('current_password') != '') {
            $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
        }
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
        $this->form_validation->set_rules('company', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('industry_id[]', 'Industry', 'trim|required');
        $this->form_validation->set_rules('functionality_id[]', 'Functionality', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|callback_mobileno_check');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|callback_mobileno_check');
        $json_array['user_data'] = $post_data;
        if (isset($post_data['profile_pic'])) {
            $json_array['user_data']['photo'] = $post_data['profile_pic'];
        } else {
            if (isset($data['user_data']['photo'])) {
                $json_array['user_data']['photo'] = $data['user_data']['photo'];
            }
        }
        $json_array['user_data']['photo'] = isset($post_data['profile_pic']) ? $post_data['profile_pic'] : '';
//        $json_array['user_data']['company_name'] = $post_data['company'];
        $json_array['user_data']['subscribe_email'] = isset($data['user_data']->subscribe_email) ? $data['user_data']->subscribe_email : '0';
//        $json_array['user_data']['industry_id'] = $post_data['industry_id'][0];
//        $json_array['user_data']['functionality_id'] = $post_data['functionality_id'][0];
        if ($this->form_validation->run() == FALSE) {
            $json_array['errors']['email_err'] = form_error('email');
            $json_array['errors']['current_password_err'] = form_error('current_password');
            $json_array['errors']['password_err'] = form_error('password');
            $json_array['errors']['conf_password_err'] = form_error('conf_password');
            $json_array['errors']['first_name_err'] = form_error('first_name');
            $json_array['errors']['last_name_err'] = form_error('last_name');
            $json_array['errors']['designation_err'] = form_error('designation');
            $json_array['errors']['company_err'] = form_error('company');
            $json_array['errors']['industry_id_err'] = form_error('industry_id[]');
            $json_array['errors']['functionality_id_err'] = form_error('functionality_id[]');
            $json_array['errors']['city_err'] = form_error('city');
            $json_array['errors']['mobile_err'] = form_error('mobile');
            $json_array['errors']['phone_err'] = form_error('phone');
            $this->load->view(CLIENT_USER_PROFILE_VIEW, $json_array);
            $redirect = FALSE;
        } else {
            $data = $this->input->post(NULL, TRUE);
            if (!$this->upload->do_upload('userimage')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $image_data = $this->upload->data();
                $config["manipulation_type"]['source_image'] = $image_data['full_path'];
                $this->load->library('image_lib', $config["manipulation_type"]);
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                $photo_data = array('upload_data' => $this->upload->data());
                $data['profile_pic'] = $photo_data['upload_data']['file_name'];
            }

            if ($attendee_id && $this->input->post('current_password') != '') {
                $db_password = $this->model->getPassword($attendee_id);
                if ($db_password != md5($this->input->post('current_password'))) {
                    $json_array['errors']['error'] = 'error';
                    $json_array['errors']['current_password_err'] = 'Invalid Current password.';
                    $this->load->view(CLIENT_USER_PROFILE_VIEW, $json_array);
//                            redirect(SITE_URL . 'profile-view',$json_array);
//                    $this->profile_view($json_array);
                }
            }

            $data['social_type'] = 'normal';
            $this->model->insert_type = 'normal';
            $data['location'] = '';
            $data['linkdin'] = '';
            $data['linkedin_id'] = '';
            //$data['profile_pic']                                                = '';    
            $data['public_profile_url'] = '';
//            display($attendee_id);
//            die;
            $this->db->where('id', $attendee_id);
            $this->db->update('attendee', array('company_name' => $post_data['company'], 'industry' => $post_data['industry_id'][0], 'functionality' => $post_data['functionality_id'][0], 'mobile' => $post_data['mobile'], 'phone' => $post_data['phone'], 'designation' => $post_data['designation']));

            $this->model->attendee_id = $attendee_id;
            $save_user = $this->model->save_user($user_id, $data);
            show_query();
            $seesion_data = array(
                'client_user_id' => $save_user['user_id'],
                'client_attendee_id' => $save_user['attendee_id'],
                'client_email' => $save_user['email'],
                'client_user_type' => $data['type_of_attendee'],
                'client_first_name' => $data['first_name'],
                'client_user_name' => $data['first_name'] . ' ' . $data['last_name'],
                'client_user_company' => $data['company'],
                'client_user_designation' => $data['designation'],
                'client_user_image' => @$data['profile_pic'],
                'client_user_city' => $data['city'],
                'client_user_industry' => $data['industry_id'],
            );
            $this->session->set_userdata($seesion_data);
            $json_array['errors']['error'] = 'success';
            $json_array['errors']['msg'] = 'Profile Saved Successfully';
            redirect(SITE_URL . 'profile-view');
        }
    }

    function mobileno_check($no) {
        if ($no) {
            if (!preg_match("/^[0-9 -+]+$/", $no) && !is_numeric($no)) {

                $this->form_validation->set_message('mobileno_check', 'Invalid Mobile No!');
                return FALSE;
            } else
                return TRUE;
        } else
            return TRUE;
    }

    function login($cookie_email = NULL, $cookie_password = NULL) {
        if ($cookie_email && $cookie_password) {
            $email = $cookie_email;
            $password = $cookie_password;
        } else {
            $email = mysql_real_escape_string($this->input->post('email', TRUE));
            $password = mysql_real_escape_string($this->input->post('password', TRUE));
        }
        $remember_me = $this->input->post('remember_me', TRUE);

        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Email/Password';
        if (!isset($email) || $email == '' || $password == '' || !isset($password)) {
            echo json_encode($json_array);
            exit;
        }

        $this->model->password = $password;
        $user_data = $this->model->check_user(NULL, $email);
        if ($user_data) {
            //display($user_data);
            if ($user_data['status'] == 1) {

                $seesion_data = array(
                    'client_user_id' => $user_data['id'],
                    'client_attendee_id' => $user_data['attendee_id'],
                    'client_email' => $user_data['email'],
                    'client_user_type' => $user_data['attendee_type'],
                    'client_first_name' => $user_data['first_name'],
                    'client_user_name' => $user_data['name'],
                    'client_user_company' => $user_data['company_name'],
                    'client_user_designation' => $user_data['designation'],
                    'client_user_image' => $user_data['photo'],
                    'client_user_city' => $user_data['city'],
                    'client_user_industry' => $user_data['attendee_industry'],
                );
                $this->session->set_userdata($seesion_data);
                $json_array['redirect'] = SITE_URL . 'events';
                if ($this->session->userdata('event_reffaral')) {
                    $json_array['redirect'] = $this->session->userdata('event_reffaral');
                }

                if ($remember_me) {
                    $cookie = array(
                        'name' => 'email',
                        'value' => $email,
                        'expire' => '865000'
                    );

                    set_cookie($cookie);

                    $cookie = array(
                        'name' => 'password',
                        'value' => $password,
                        'expire' => '865000'
                    );
                    set_cookie($cookie);
                }
                $json_array['error'] = 'success';
                $json_array['msg'] = 'success';
            } else {
                $json_array['error'] = 'error';
                $json_array['msg'] = 'User has been Blocked!';
            }
        }
        if ($cookie_email && $cookie_password) {
            return $json_array;
        }
        echo json_encode($json_array);
    }

    function saved_profile() {
        $attebdee_id = $this->session->userdata('client_attendee_id');
        if (!$attebdee_id)
            redirect(SITE_URL . 'events');

        $user_type_array = array('attendee', 'exhibitor', 'speaker');
        $user_type = $this->uri->segment(3);
        $event_id = $this->session->userdata('client_event_id');
        $attendee_type = '';
        if (in_array($user_type, $user_type_array)) {
            if ($user_type == 'attendee')
                $attendee_type = 'A';
            elseif ($user_type == 'exhibitor')
                $attendee_type = 'E';
            elseif ($user_type == 'speaker')
                $attendee_type = 'S';
            $this->client_notification_model->attendee_type = $attendee_type;
            $data['page_type'] = $user_type;

            $data['saved_profile'] = $this->client_notification_model->getSocialMessage($attebdee_id, $event_id);
            $this->load->view(CLIENT_USER_SAVED_PROFILE_VIEW, $data);
            //display($data);
        }
        else {
            echo '404';
        }
    }

    function verify_change_password() {
        $this->load->helper('emailer_helper');
        $this->load->model('client/client_event_model');
        $email_placehoder = array('first_name', 'password_link');
        $email = $this->input->post('email');
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Email Address!';
        if ($email) {
            $check_user = $this->client_event_model->getUser($email);
            if ($check_user) {
                $user_data = $check_user[0];
                //display($user_data);
                $password_key = md5($user_data['user_id']);

                $this->db->where('id', $user_data['user_id']);
                $this->db->update('user', array('password_key' => $password_key));

                $to = $email;
                $password_link = '<a href="' . SITE_URL . 'user/change-password/' . $password_key . '">Click</a>';

                //MAIL TEMLATE***
                $email_template = get_email_template('forget_password');
                $keywords = array('{app_name}', '{first_name}', '{password_link}', '{app_contact_email}', '{site_url}', '{IMAGE_PATH}', '{logo_image}', '{apple_app_store}', '{google_play_store}');
                $replace_with = array(
                    $email_template['setting']['app_name'],
                    $user_data['first_name'],
                    $password_link,
                    $email_template['setting']['app_contact_email'],
                    SITE_URL,
                    CLIENT_IMAGES,
                    '<img src="' . SITE_URL . 'uploads/app_logo/' . $email_template['setting']['app_logo_big'] . '">', '<a href=' . $email_template['setting']['apple_app_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . APPLE_APP_STORE_IMAGE . '"></a>', '<a href=' . $email_template['setting']['google_play_store'] . '><img src="' . SITE_URL . 'uploads/app_store_images/' . GOOGLE_PLAY_STORE_IMAGE . '"></a>'
                );
                $subject = str_replace($keywords, $replace_with, $email_template['subject']);
                $html = str_replace($keywords, $replace_with, $email_template['body']);
                //MAIL TEMLATE CLOSE***
//                $subject = 'Change password for your Procialize App';
//                $html = str_replace('{first_name}', $user_data['first_name'], forget_password_temp());
//                $html = str_replace('{password_link}', $password_link, $html);
//                $html = str_replace('{IMAGE_PATH}', CLIENT_IMAGES, $html);
//

                header('content-type: text/html; charset=UTF-8');
                sendMail($to, $subject, '', $html);
                $json_array['error'] = 'success';
                $json_array['msg'] = 'Password Reset Link has been sent to your email adderess';
            }
        }

        echo json_encode($json_array);
    }

    function change_password_view() {
        $password_key = $this->uri->segment(3);
        if ($password_key) {
            $check_password_key = $this->model->CheckPasswordKey($password_key);
            //display($check_password_key);
            if (!$check_password_key) {
                $data['error_message'] = 'Invalid Password key';
                $this->load->view(CLIENT_DATA_ERROR_VIEW, $data);
                return;
            }
            $data['password_key'] = $password_key;
            $this->load->view(CLIENT_USER_RESET_PASSWORD_VIEW, $data);
        } else {
            $data['error_message'] = 'Invalid Password key';
            $this->load->view(CLIENT_DATA_ERROR_VIEW, $data);
        }
    }

    function change_password() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');


        if ($this->form_validation->run() == FALSE) {
            $json_array['error'] = 'error';
            $json_array['msg'] = 'Something went wrong';
            $json_array['password_err'] = form_error('password');
            $json_array['conf_password_err'] = form_error('conf_password');
        } else {

            $data = $this->input->post(NULL, NULL);
            //display($data);
            $update_password = $this->model->reset_password($data);

            $json_array['error'] = 'success';
            $json_array['msg'] = 'Password updated successfully!';
        }

        echo json_encode($json_array);
    }

}
