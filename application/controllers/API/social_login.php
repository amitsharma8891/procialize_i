<?php

class Social_login extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	user controller
     * @author		Amit  sharma
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('client/client_login_model', 'model');
    }

    function login() {
        $email = mysql_real_escape_string($this->input->post('email', TRUE));
        $password = mysql_real_escape_string($this->input->post('password', TRUE));
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid User!';
        if (!isset($email) || $email == '' || $password == '' || !isset($password)) {
            echo json_encode($json_array);
            exit;
        }

        $user_data = $this->model->getUser($email, $password);
        if ($user_data) {
            $user_data = $user_data[0];
            if ($user_data['status'] == 1) {

                $seesion_data = array(
                    'client_user_id' => $user_data['user_id'],
                    'client_email' => $user_data['email'],
                    'client_user_type' => $user_data['type_of_user'],
                    'client_first_name' => $user_data['first_name'],
                );
                $this->session->set_userdata($seesion_data);
                $json_array['redirect'] = SITE_URL . 'events';
                if ($this->session->userdata('event_reffaral')) {
                    $json_array['redirect'] = $this->session->userdata('event_reffaral');
                }
                $json_array['error'] = 'success';
            } else {
                $json_array['error'] = 'error';
                $json_array['msg'] = 'User has been Blocked!';
            }
        }

        echo json_encode($json_array);
    }

    function facebook() {
        $data['social_type'] = 'facebook';
        $data['functionality_id'] = array();
        $data['industry_id'] = array();
        $data['fb_id'] = $this->input->post('fb_id');
        $data['email'] = $this->input->post('email');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['profile_pic'] = $this->input->post('profile_pic');
        $data['public_profile_url'] = $this->input->post('public_profile_url');
        $data['company'] = '';
        $data['designation'] = '';
        $data['city'] = '';
        $data['country'] = '';
        $data['location'] = '';
        $data['description'] = '';
        $data['type_of_attendee'] = 'A';
        if ($data['email']) {
            $user_data = $this->model->check_user(NULL, $data['email']); //check for user
            if (!$user_data) {

                if ($data['profile_pic']) {
                    $url = $data['profile_pic'];
                    $image_data = file_get_contents($url);
                    $fileName = $data['fb_id'] . 'facebook.jpg';
                    $save_path = UPLOADS . 'attendee/';
                    file_put_contents($save_path . $fileName, $image_data);
                    $profile_pic = $data['profile_pic'] = $fileName;
                }
                $user_data = $this->model->save_user(NULL, $data);
                $user_id = $user_data['user_id'];
                $attendee_id = $user_data['attendee_id'];
            } else {
                if (!$user_data['facebook']) {
                    $this->model->attendee_id = $user_data['attendee_id'];
                    $user_data_update = $this->model->save_user($user_data['id'], $data);
                }
            }
            $user_data = $this->model->check_user(NULL, $data['email']);
            $this->set_client_session($user_data);
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Success';
        }
        echo json_encode($json_array);
    }

    function linkedin() {
        $data['social_type'] = 'linkedin';
        $data['functionality_id'] = array();
        $data['linkedin_id'] = $this->input->post('linkedin_id');
        $data['email'] = $this->input->post('email');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['profile_pic'] = $this->input->post('profile_pic');
        $data['industry'] = $this->input->post('industry');
        $data['position'] = $this->input->post('position');
        $data['skills'] = $this->input->post('skills');
        $data['location'] = $this->input->post('location');
        $data['public_profile_url'] = $this->input->post('public_profile_url');
        $data['type_of_attendee'] = 'A';
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Something Went Wrong';
        //display($this->input->post());
        if ($data['email']) {
            //check for user
            //display($user_data);
            $data['company'] = $data['position']['values'][0]['company']['name'];
            $data['designation'] = $data['position']['values'][0]['title'];
            $data['location'] = $data['location']['name'];
            $temp = explode(',', $data['location']);
            $data['city'] = $temp[0];
            $data['country'] = $temp[1];
            $data['description'] = $data['designation'];
            $data['industry_id'][] = $this->check_industry($data['industry']);
            $functions = $data['skills']['values'];
            if ($functions) {
                foreach ($functions as $k => $v) {
                    $data['functionality_id'][] = $this->check_functionality($v['skill']['name']);
                }
            }
            $user_data = $this->model->check_user(NULL, $data['email']);
            if (!$user_data) {

                if ($data['profile_pic']) {
                    $url = $data['profile_pic'];
                    $image_data = file_get_contents($url);
                    $fileName = $data['linkedin_id'] . '_linkdin.jpg';
                    $save_path = UPLOADS . 'attendee/';
                    file_put_contents($save_path . $fileName, $image_data);
                    $profile_pic = $data['profile_pic'] = $fileName;
                }
                $user_data = $this->model->save_user(NULL, $data);
            } else {
                if (!$user_data['linkden']) {
                    $this->model->attendee_id = $user_data['attendee_id'];
                    $user_data_update = $this->model->save_user($user_data['id'], $data);
                }
            }

            $user_data = $this->model->check_user(NULL, $data['email']);
            $this->set_client_session($user_data);
            $json_array['error'] = 'success';
            $json_array['msg'] = 'Success';
        }
        echo json_encode($json_array);
    }

    function set_client_session($user_data) {
        $session_data = array(
            'client_user_id' => $user_data['id'],
            'client_attendee_id' => $user_data['attendee_id'],
            'client_email' => $user_data['email'],
            'client_user_type' => $user_data['type_of_user'],
            'client_first_name' => $user_data['first_name'],
            'client_user_name' => $user_data['name'],
            'client_user_company' => $user_data['company_name'],
            'client_user_designation' => $user_data['designation'],
            'client_user_image' => $user_data['photo'],
            'client_user_city' => $user_data['city'],
            'client_user_industry' => $user_data['attendee_industry'],
        );
        $this->session->set_userdata($session_data);
    }

    function check_industry($industry_data) {
        $check_industry = $this->model->getIndustry(NULL, $industry_data);
        if ($check_industry)
            $industry = $check_industry[0]['id'];

        if (!$check_industry) {
            $industry = $this->model->save_industry_functionality('industry', $industry_data); //$check_industry;
        }

        return $industry;
    }

    function check_functionality($functionality_data) {
        $check_functionality = $this->model->getFunctionality(NULL, $functionality_data);

        if ($check_functionality)
            $functionality = $check_functionality[0]['id'];

        if (!$check_functionality) {
            $functionality = $this->model->save_industry_functionality('functionality', $functionality_data); //$check_industry;
        }

        return $functionality;
    }

}
