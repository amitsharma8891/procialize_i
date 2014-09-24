<?php

class Speaker extends CI_Controller {

    public $event_id;

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Rohan Patil
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {

        parent::__construct();

        $this->load->model('speaker_model');
        $this->load->model('attendee_model', 'model');
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->load->model('industry_model');
        $this->load->model('functionality_model');
        $this->load->model('has_model');
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    /**
     * index
     *
     * This displays  content
     * 
     * @author	Rohan Patil
     * @access	public
     * @params	null
     * @return	void
     */
    public function index($order = NULL) {

        setcookie("postarray", "", time() - 3600);
        $this->model->status = array("0", "1");
        $this->model->order_name = 'attendee.name';
        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
        $selected_event = 0;
        if ($this->input->post('event_drpdown') != 0) {
            $selected_event = $this->input->post('event_drpdown');
            $this->session->set_userdata('selected_event', $selected_event);
        } else {
            if ($this->session->userdata('selected_event')) {
                $selected_event = $this->session->userdata('selected_event');
            }
        }
        if ($this->input->post('event_drpdown') == 0 && $order == "") {
            if (!empty($arrData['event_dropdown']) && isset($arrData['event_dropdown'])) {
                $i = 0;
                foreach ($arrData['event_dropdown'] as $key => $value) {
                    if ($i == 1) {
                        $selected_event = $key;
                        $i++;
                    } else {
                        $i++;
                        continue;
                    }
                }
            }

            if ($this->input->post('event_drpdown') == 0 && $this->input->post('send_passcode') == '' && $this->input->post('search') == '') {
                if ($selected_event) {
                    $search = $selected_event;
                    $drop_down_search = $selected_event;
                    $field = array("event_has_attendee.event_id");
                    $this->model->status = array("0", "1");
                    $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
                }
            }
        }
        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'organizer.id';
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'attendee.id';
            $this->model->order_by = 'DESC';
        }


        if ($order == 3) {

            $search = 0;
            $field = array("attendee.mail_sent");
            $drop_down_search = $selected_event;
            $arrData['list'] = $this->speaker_model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        } elseif ($order == 4) {
            $search = '1';
            $field = array("attendee.mail_sent");
            $drop_down_search = $selected_event;
            $arrData['list'] = $this->speaker_model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        } else {

            $search = $selected_event;
            $drop_down_search = $selected_event;
            $field = array("event_has_attendee.event_id");
            $drop_down_search = $selected_event;
            $arrData['list'] = $this->speaker_model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        }
        if ($this->input->post()) {
            if ($this->input->post('send_mail') != '') {
                $this->model->attendee_type = array('S');
                $status = $this->model->sendPasscode($this->input->post('delete'));
                $this->model->attendee_type = array('A','E');
                if ($status) {
                    $this->session->set_flashdata('message', 'Mail sent successfully');
                    redirect('manage/speaker');
                } else {
                    $this->session->set_flashdata('message', "Mail not sent to one or more people due to invalid email address. Please select 'Sort by' as 'Mail not Sent' and find out the result. ");
                    redirect('manage/speaker');
                }
            }
            if ($this->input->post('delete') && $this->input->post('send_mail') == '') {

                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Speaker Deleted Successfully.');
                    redirect('manage/speaker');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Speaker');
                    redirect('manage/speaker');
                }
            }
            if ($this->input->post('search') != '' && $this->input->post('send_mail') == '') {

                $search = $this->input->post('search');
                $field = array("user.first_name", "user.last_name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->speaker_model->getAll(NULL, FALSE, $search, $field);
//                                echo $this->db->last_query();exit;
            }

            if ($this->input->post('event_drpdown') != '' && $this->input->post('search') == '') {
                $search = $this->input->post('event_drpdown');
                $field = array("event_has_attendee.event_id");
                $this->model->status = array("0", "1");
                $drop_down_search = $selected_event;
                $arrData['list'] = $this->speaker_model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
//                echo $this->db->last_query();exit;
            }
        }
        //echo '<pre>'; print_r($arrData['list']); exit;
        $arrData['selected_event'] = $selected_event;
        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
        $arrData['thisPage'] = 'Default Speaker';
        $arrData['breadcrumb'] = 'Speaker';
        $arrData['breadcrumb_tag'] = ' Description for Speaker goes here';
        $arrData['breadcrumb_class'] = 'fa-home';

        $arrData['middle'] = 'admin/speaker/index';
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
        $arrData['fields'] = $fields = $this->speaker_model->generate_fields();
//        echo '<pre>';print_r($arrData); exit;
        if ($this->input->post()) {
            $noFileError = TRUE;
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);

//            $arrData['fields']['fields']['username']['validate'] = 'required|is_unique[user.username]';
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE && $noFileError === TRUE) {
                unset($arrInsert['btnSave']);
                $email = $arrInsert['email'];
                $arrInsert['name'] = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                $event_id = $arrInsert['event_id'];
                $arrCheck['email'] = $email;
                $attendee_exist_id = $this->model->check_attendee($arrCheck);

                if (!$attendee_exist_id)
                    $attendee_exist_id = NULL;

                $upload_status = $this->speaker_model->savePhoto($arrInsert, $fields);
                //echo '==='.$upload_status; exit;
                if (!$upload_status) {
                    $this->session->set_flashdata('message', $arrInsert[0]);
                    redirect('manage/speaker/add');
                }
                $arrInsert['top_level_id'] = getTopLevelId();
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrInsert['attendee_type'] = 'S';

//                echo '<pre>'; print_r($arrInsert); exit;
                $status = $this->model->saveAll($arrInsert, $attendee_exist_id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Speaker Added Successfully !!');
                    redirect('manage/speaker');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add Speaker!!');
                    redirect('manage/speaker/add');
                }
            }
        }

        $arrData['thisPage'] = 'Add Speaker';
        $arrData['breadcrumb'] = 'Add Speaker';
        $arrData['breadcrumb_tag'] = ' All elements to add an Speaker..';
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
    /* public function edit($id = NULL) {
      //echo '<pre>'; print_r($_POST); exit;
      $arrData['fields'] = $fields = $this->model->generate_fields($id);
      //        echo '<pre>'; print_r($arrData['fields']); exit;
      $arrData['fields']['fields']['email']['validate'] = 'required|trim';
      $arrData['fields']['fields']['first_name']['validate'] = 'required|trim';
      if ($this->input->post()) {

      formVaidation($arrData['fields'], $this);
      if ($this->form_validation->run() === TRUE) {
      $arrInsert = $this->input->post();
      $postarray = json_encode($arrInsert);
      setcookie('postarray', $postarray);
      unset($arrInsert['btnSave']);
      //echo '<pre>'; print_r($_FILES); exit;
      $first_name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
      $email = $arrInsert['email'];
      $event_id = $arrInsert['event_id'];
      $check_unique = $this->model->check_unique($first_name, $email, $event_id, $id);
      //echo $check_unique; exit;
      if ($check_unique) {
      $this->session->set_flashdata('message', 'Speaker with same First name, Email and Event found !!');
      redirect('manage/speaker');
      } else {
      if ($_FILES['speaker_photo']['name'] != '' || $_FILES['speaker_profile']['name'] != '') {

      $upload_status = $this->model->savePhoto($arrInsert, $fields);
      if (!$upload_status) {
      $this->session->set_flashdata('message', $arrInsert[0]);
      redirect('manage/speaker/edit/' . $id);
      }
      }
      $arrInsert['name'] = $this->input->post('first_name') . ' ' . $this->input->post('last_name');

      //echo '<pre>'; print_r($arrInsert); exit;
      $status = $this->model->saveAll($arrInsert, $id);
      if ($status) {
      $this->session->set_flashdata('message', 'Speaker Edited Successfully !!');
      redirect('manage/speaker');
      } else {
      $this->session->set_flashdata('message', 'Failed to Edit Speaker!!');
      redirect('manage/speaker/edit/' . $id);
      }
      }
      }
      }


      $arrData['thisPage'] = 'Default Speaker';
      $arrData['breadcrumb'] = 'Edit Speaker';
      $arrData['breadcrumb_tag'] = ' All elements to edit an Speaker..';
      $arrData['breadcrumb_class'] = 'fa-flask';
      $arrData['middle'] = 'admin/middle_template';
      $this->load->view('admin/default', $arrData);
      } */

    function edit($id) {

        //echo '<pre>'; print_r($_POST); exit;
        $arrData['fields'] = $fields = $this->speaker_model->generate_fields($id);
//        echo '<pre>';print_r($arrData); exit;
        if ($this->input->post()) {
            $noFileError = TRUE;
            $arrInsert = $this->input->post();

            if ($this->speaker_model->object->email != $arrInsert['email']) {
                $arrCheck['email'] = $arrInsert['email'];
                $check_attendee = $this->model->check_attendee($arrCheck);
                if ($check_attendee != FALSE) {
                    $this->session->set_flashdata('message', 'Speaker Email already exist!!');
                    redirect('manage/speaker/edit/' . $id);
                }
            }

//            $arrData['fields']['fields']['username']['validate'] = 'required|is_unique[user.username]';
            formVaidation($arrData['fields'], $this);

            if ($this->form_validation->run() === TRUE && $noFileError === TRUE) {
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                unset($arrInsert['btnSave']);
                $email = $arrInsert['email'];
                $event_id = $arrInsert['event_id'];
                $arrCheck['email'] = $email;
                $upload_status = $this->speaker_model->savePhoto($arrInsert, $fields);
                //echo '==='.$upload_status; exit;
                if (!$upload_status) {
                    $this->session->set_flashdata('message', $arrInsert[0]);
                    redirect('manage/speaker/add');
                }
                $arrInsert['name'] = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                $arrInsert['top_level_id'] = getTopLevelId();
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrInsert['attendee_type'] = 'S';

//                echo '<pre>'; print_r($arrInsert); exit;
                $status = $this->model->saveAll($arrInsert, $id);
                if ($status) {
                    $this->session->set_flashdata('message', 'Speaker Edited Successfully !!');
                    redirect('manage/speaker');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Edit Speaker!!');
                    redirect('manage/speaker/edit/' . $id);
                }
            }
        }

        $arrData['thisPage'] = 'Edit Speaker';
        $arrData['breadcrumb'] = 'Edit Speaker';
        $arrData['breadcrumb_tag'] = ' All elements to edit an Speaker..';
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
                $arrResult['message'] = 'Speaker Deleted Successfully.';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Failed to Delete Speaker.';
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