<?php

class Survey extends CI_Controller {

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
        $this->load->model('survey_model', 'model');
        $this->load->model('event_model');
        $this->load->model('notification_model');
        $this->load->model('exhibitor_model');
        $this->load->model('speaker_model');
        $this->load->model('attendee_model');
        $this->load->model('has_model');
		$this->load->model('push_notification/mobile_push_notification_model','mobile_model');
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
    public function index($order = 0) {
//        print_r($this->session->all_userdata());exit;
        $this->model->status = array("0", "1");
//        $this->model->order_name = 'survey.name';

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        }



        $arrData['list'] = $this->model->getAll();
        if ($this->input->post()) {
            if ($this->input->post('delete')) {
                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Survey Deleted Successfully.');
                    redirect('manage/survey');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Survey');
                    redirect('manage/survey');
                }
            }
            if ($this->input->post('search') != '') {
                $search = $this->input->post('search');
                $field = array("survey.name", "name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
            }
            if ($this->input->post('event_drpdown') != '' && $this->input->post('search') == '') {
                $search = $this->input->post('event_drpdown');
                $field = array("survey.event_id");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND');
//                echo $this->db->last_query();exit;
            }
        }
        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
        $arrData['breadcrumb'] = 'Survey';
        $arrData['breadcrumb_tag'] = ' Description for survey goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $this->model->status = array("0", "1", NULL);

        $arrData['middle'] = 'admin/survey/index';
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
        if ($this->input->post()) {
            
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert['url'] = $this->input->post('url');
                $arrInsert['name'] = $this->input->post('name');
                $arrInsert['status'] = 1;
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date('Y-m-d h:i:s');
                $arrInsert['type'] = 'S';
                $arrInsert['event_id'] = ($this->input->post('event_id')== '')?$this->event_id :$this->input->post('event_id'); ;//$this->event_id;
                $event_id = $this->input->post('event_id');
                $id = NULL;
                $unique = $this->model->check_unique($arrInsert['name'],$event_id,$id);
                if(!$unique) {
                    $this->session->set_flashdata('message', 'Survey name already present.');
                    redirect('manage/survey');
                }

                if ($this->input->post('now')) {
                    $arrInsert['display_time'] = date("Y-m-d H:i:s");
                } else {
                    $date = $this->input->post('date');
                    $arrInsert['display_time'] = $date . " " . $this->input->post('time');
                }
                //echo 'save<pre>'; print_r($arrInsert); exit;
                $id = $this->model->save($arrInsert);

                //$arrInsert['content'] = "<a href='" . base_url('survey/'.$id) . "'>".$arrInsert['name'].'</a>';
                $arrInsert['content'] = $arrInsert['name'];

//                unset($arrInsert['event_id']);
                unset($arrInsert['url']);
                unset($arrInsert['name']);
                $arrInsert['object_id'] = $this->session->userdata('id');
                $arrInsert['object_type'] = $this->session->userdata('type_of_user');
                $arrInsert['survey_id'] = $id;
                $arrInsert['event_id'] = $this->input->post('event_id');
                $arrSave = array();
                if ($this->input->post('Exhibitor')) {
                    $arrData = array();
                    $search = $this->input->post('event_id');
                    $field = array("exhibitor.event_id");
                    $arrData = $this->exhibitor_model->getAll(NULL, FALSE, $search, $field, 'exhibitor.id', 'AND');
//            echo $this->db->last_query();
                    foreach ($arrData as $ele) {
                        $arrInsert['subject_id'] = $ele['exhibitor_id'];
                        $arrInsert['subject_type'] = 'E';
                        $arrInsert['survey_id'] = $id;
                        $arrSave[] = $arrInsert;
                    }
                }

                if ($this->input->post('Attendee/Speaker')) {
                    $arrData = array();
                    $search = $this->input->post('event_id');
                    $field = array("event_has_attendee.event_id");
                    $arrData = $this->attendee_model->getAll(NULL, FALSE, $search, $field, 'AND');
//            echo $this->db->last_query();
                    foreach ($arrData as $ele) {
                        $arrInsert['subject_id'] = $ele['attendee_id'];
                        $arrInsert['subject_type'] = 'A';
                        $arrSave[] = $arrInsert;
                    }
                } elseif ($this->input->post('attendee_id')) {
                    foreach ($this->input->post('attendee_id') as $attendee_id) {
						$arrData = $this->attendee_model->getAll($attendee_id, FALSE, $search=NULL, $field=NULL, 'AND');
						$mobile_notification = 'Organizer has sent you a Survey Request';
						$gcm_reg_id = $arrData[0]['gcm_reg_id'];
						$mobile_os = $arrData[0]['mobile_os'];
                        $arrInsert['subject_id'] = $attendee_id;
                        $arrInsert['subject_type'] = 'A';
                        $arrSave[] = $arrInsert;
						if($gcm_reg_id)
						{
							$responce = $this->mobile_model->send_notification($gcm_reg_id,$mobile_os,$mobile_notification);
						}
                    }
                }
                //echo 'livesur<pre>'; print_r($arrSave); exit;
                $status = false;
                if (!empty($arrSave)) {

                    $status = $this->notification_model->save($arrSave);
                }

                if ($status) {
                    $this->session->set_flashdata('message', 'Survey Added Successfully !!');
                    redirect('manage/survey');
                } else {
//                    $this->session->set_flashdata('message', 'Failed to Add Survey!!');
                    redirect('manage/survey/');
                }
            }
        }
        $arrData['thisPage'] = 'Default Attendee';
        $arrData['breadcrumb'] = 'Add Survey';
        $arrData['breadcrumb_tag'] = ' All elements to add an Survey..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/survey/add';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * edit
     *
     * edit content
     * 
     * @author  Rohan
     * @access  public
     * @params  null
     * @return  void
     */
    function edit($id = NULL) {

        if (is_null($id))
            redirect('manage/survey/add');

        $arrData['fields'] = $fields = $this->model->generate_fields($id);
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert['url'] = $this->input->post('url');
                $arrInsert['name'] = $this->input->post('name');
                $arrInsert['content'] = SURVEY_CONTENT_PRE . $arrInsert['url'] . SURVEY_CONTENT_POST;
                $arrInsert['status'] = 1;
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date('Y-m-d h:i:s');
                $arrInsert['type'] = 'S';
                $arrInsert['event_id'] = $this->input->post('event_id');//$this->event_id;
                $event_id = $this->input->post('event_id');
               
                $unique = $this->model->check_unique($arrInsert['name'],$event_id,$id);
                if(!$unique) {
                    $this->session->set_flashdata('message', 'Survey name already present.');
                    redirect('manage/survey');
                }

                if ($this->input->post('now')) {
                    $arrInsert['display_time'] = date("Y-m-d H:i:s");
                } else {
                    $date = $this->input->post('date');
                    $arrInsert['display_time'] = $date . " " . $this->input->post('time');
                }
                $status = false;
                
                $status = $this->model->save($arrInsert, $id);

                unset($arrInsert['event_id']);
                unset($arrInsert['url']);
                unset($arrInsert['name']);
                $arrInsert['object_id'] = $this->session->userdata('id');
                $arrInsert['object_type'] = $this->session->userdata('type_of_user');
                $arrSave = array();
                if ($this->input->post('Exhibitor')) {
                    $arrData = array();
                    $search = $this->event_id;
                    $field = array("exhibitor.event_id");
                    $arrData = $this->exhibitor_model->getAll(NULL, FALSE, $search, $field, 'exhibitor.id', 'AND');
//            echo $this->db->last_query();
                    foreach ($arrData as $ele) {
                        $arrInsert['subject_id'] = $ele['exhibitor_id'];
                        $arrInsert['subject_type'] = 'E';
                        $arrSave[] = $arrInsert;
                    }
                }

                if ($this->input->post('Attendee/Speaker')) {
                    $arrData = array();
                    $search = $this->event_id;
                    $field = array("speaker.event_id");
                    $arrData = $this->speaker_model->getAll(NULL, FALSE, $search, $field, 'AND');
//            echo $this->db->last_query();
                    foreach ($arrData as $ele) {
                        $arrInsert['subject_id'] = $ele['speaker_id'];
                        $arrInsert['subject_type'] = 'S';
                        $arrSave[] = $arrInsert;
                    }


                    $arrData = array();
                    $search = $this->event_id;
                    $field = array("event_has_attendee.event_id");
                    $arrData = $this->attendee_model->getAll(NULL, FALSE, $search, $field, 'AND');
//            echo $this->db->last_query();
                    foreach ($arrData as $ele) {
                        $arrInsert['subject_id'] = $ele['attendee_id'];
                        $arrInsert['subject_type'] = 'A';
                        $arrSave[] = $arrInsert;
                    }
                } elseif ($this->input->post('attendee_id')) {
                    foreach ($this->input->post('attendee_id') as $attendee_id) {
                        $arrInsert['subject_id'] = $attendee_id;
                        $arrInsert['subject_type'] = 'A';
                        $arrSave[] = $arrInsert;
                    }
                }

                $status = false;
                if (!empty($arrSave)) {
                    $status = $this->notification_model->save($arrSave);
                }

                if ($status) {
                    $this->session->set_flashdata('message', 'Survey Edited Successfully !!');
                    redirect('manage/survey');
                } else {
//                    $this->session->set_flashdata('message', 'Failed to Add Survey!!');
                    redirect('manage/survey/');
                }
            }
        }
        $arrData['thisPage'] = 'Default Attendee';
        $arrData['breadcrumb'] = 'Edit Survey';
        $arrData['breadcrumb_tag'] = ' All elements to edit an Survey..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/survey/add';
        $this->load->view('admin/default', $arrData);
    }

    function delete($json = 'noJson') {
        $arrResult = array();

        if ($this->input->post('id')) {
            $status = $this->model->delete($this->input->post('id'));
            if ($status) {
                $arrResult['status'] = TRUE;
                $arrResult['message'] = 'Survey Deleted Successfully';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Failed to Delete Survey.';
            }
        }
        if ($json = 'json') {
            echo json_encode($arrResult);
            exit;
        }
    }

}