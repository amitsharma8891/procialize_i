<?php

class Image_maping extends CI_Controller {

    public $superadmin = false;

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	Index controller
     * @author		Anupam
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('image_map_model', 'model');
        $this->load->model('event_model');
        $this->load->model('attendee_model');
        $this->load->model('map_exhibitor_model');
        $this->load->model('exhibitor_model');
        $this->load->library('form_validation');
        $this->superadmin = $this->session->userdata('is_superadmin');
    }

    /**
     * index
     *
     * This displays  content
     * 
     * @author	Anupam
     * @access	public
     * @params	null
     * @return	void
     */
    public function index($order = NULL) {
        setcookie("postarray", "", time() - 3600);
        $this->model->name = 'image_map.name';
        $this->db->select('event.name,event.id');
        $event_list = $this->db->get('event');
        $event_list = $event_list->result_array();
        $arrData['event_list'] = $event_list;
        $search = "";
        $field = '';
        $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'image_map.id', 'AND');
        $arrData['thisPage'] = 'Default Image Maping';
        $arrData['breadcrumb'] = ' Image Maping';
        $arrData['breadcrumb_tag'] = ' Description for Image Maping goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $arrData['middle'] = 'admin/image_maping/index';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * add
     *
     * add content
     * 
     * @author  Anupam
     * @access  public
     * @params  null
     * @return  void
     */
    function add($id = NULL) {
        $config['upload_path'] = UPLOADS . 'event_image_maping/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $config['quality'] = 100;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $this->db->select('event.name,event.id');
        $organizer_id = $this->session->userdata('id');
        $this->db->where('event.organizer_id', $organizer_id);
        $event_list = $this->db->get('event');
        $event_list = $event_list->result_array();
        $this->load->library('upload', $config);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('coordinates', 'Coordinates', 'required');
        $this->form_validation->set_rules('event_id', 'Envent id', 'required');
        if ($this->input->post()) {
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);
            if (!$this->upload->do_upload('image_name')) //{
                $error = array('error' => $this->upload->display_errors());

            $image_data = $this->upload->data();
            if ($id) {
                if (isset($image_data['file_name']) && !empty($image_data['file_name']))
                    $arrInsert['image_name'] = $image_data['file_name'];
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                $status = $this->model->saveAll($arrInsert, $id);
            }else {
                $arrInsert['image_name'] = $image_data['file_name'];
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                $status = $this->model->saveAll($arrInsert);
                $id = $status;
            }
            if ($status) {
                $this->session->set_flashdata('message', 'Image Maping Added Successfully !!');
                redirect('manage/image_maping/add/' . $id);
            } else {
                $this->session->set_flashdata('message', 'Failed to Add Image Maping !!');
                redirect('manage/image_maping/add/' . $id);
            }
        }
        $arrData['event_list'] = $event_list;
        $parent_list = $this->db->where('image_map.parent_id', 0);
        $parent_list = $this->db->get('image_map');
        $parent_list = $parent_list->result_array();
        $arrData['parent_list'] = $parent_list;
        $arrData['list'] = $this->model->get($id);
        $arrData['event_image_map_status'] = 0;
        if (!empty($arrData['list'])) {
            $arrData['event_image_map_status'] = 1;
        }
        $arrData['thisPage'] = 'Default Event Map';
        $arrData['breadcrumb'] = 'Add Event Map';
        $arrData['event_image_map'] = 'event_image_map';
        $arrData['breadcrumb_tag'] = ' All elements to add an Image for an event...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/image_maping/add';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * validate email template
     *
     * validate email template content
     * 
     * @author  Anupam
     * @access  public
     * @params  null
     * @return  void
     */
    function validate_image_maping() {
        $this->load->library('form_validation');
        $arrInsert = $this->input->post();
        if (empty($arrInsert['email_id'])) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[image_map.event_id]');
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required');
        }
//        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('coordinates', 'Coordinates', 'required');
        //print_r($this->input->post());

        if ($this->form_validation->run() == FALSE) {
            $json_array['error'] = 'error';
            $json_array['name_err'] = form_error('name');
//            $json_array['subject_err'] = form_error('subject');
            $json_array['coordinates_err'] = form_error('coordinates');
        } else {
            $json_array['error'] = 'success';
            $arrInsert['created_by'] = getCreatedUserId();
            $arrInsert['created_date'] = date("Y-m-d H:i:s");
            $status = $this->model->saveAll($arrInsert);
        }

        echo json_encode($json_array);
    }

    function map_exhibitor($maped_event_image_id = NULL) {
        setcookie("postarray", "", time() - 3600);
        if ($this->input->post()) {
            $id = $maped_event_image_id;
            $arrInsert = $this->input->post();
            $arrInsert['map_id'] = $arrInsert['image_map_id'];
            if (!empty($arrInsert['child_map_id']) && $arrInsert['child_map_id']) {
                $arrInsert['child_map_id'] = $arrInsert['child_map_id'];
            } else {
                $arrInsert['child_map_id'] = 0;
            }
            $map_exhibitor_id = $arrInsert['map_exhibitor_id'];
            $coordinates = $arrInsert['coordinates'];

            if ($map_exhibitor_id) {
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                unset($arrInsert['image_map_id']);
                $status = $this->map_exhibitor_model->saveAll($arrInsert, $map_exhibitor_id, $coordinates);
            } else {
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                unset($arrInsert['image_map_id']);
                $status = $this->map_exhibitor_model->saveAll($arrInsert);
            }
            if ($status) {
                $this->session->set_flashdata('message', 'Image Maping Added Successfully !!');
                redirect('manage/image_maping/map_exhibitor/' . $maped_event_image_id);
            } else {
                $this->session->set_flashdata('message', 'Failed to Add Image Maping !!');
                redirect('manage/image_maping/map_exhibitor/' . $maped_event_image_id);
            }
        }
        $search = "";
        $field = "";
        $arrData['list'] = $this->model->getAll($maped_event_image_id, '1', $search, $field, 'image_map.id', 'AND');
        if (!empty($arrData['list'])) {
            $event_id = $arrData['list']->event_id;
            $fields = array('exhibitor.event_id');
            $search = $event_id;
            $arrData['exhhibitor_list'] = $this->exhibitor_model->getAll(NULL, NULL, $search, $fields, NULL, NULL, NULL);
            $exhibitor_list_data = array();
            $ii = 0;
            foreach ($arrData['exhhibitor_list'] as $ex_value) {
//                if ($ex_value['contact_gcm_reg_id'] !== '') {
                $exhibitor_list_data[$ii] = $ex_value;
                $ii++;
//                }
            }
            $arrData['exhhibitor_list'] = $exhibitor_list_data;
        }
        $arrData['thisPage'] = 'Default Event Map';
        $arrData['breadcrumb'] = ' Event Map';
        $arrData['breadcrumb_tag'] = ' Description for Image Maping goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $arrData['middle'] = 'admin/image_maping/map_exhibitor';
        $this->load->view('admin/default', $arrData);
    }

    function add_child($maped_event_image_id = NULL) {
        $config['upload_path'] = UPLOADS . 'event_image_maping/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $config['quality'] = 100;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->input->post()) {
            if (!$this->upload->do_upload('image_name')) //{
                $error = array('error' => $this->upload->display_errors());
            $arrInsert = $this->input->post();
            $arrInsert['parent_id'] = $arrInsert['parent_id'];
            $id = $arrInsert['child_id'];
            // add_child***********
            $image_data = $this->upload->data();
            if ($id) {
                if (isset($image_data['file_name']) && !empty($image_data['file_name']))
                    $arrInsert['image_name'] = $image_data['file_name'];
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                $status = $this->model->saveAll($arrInsert, $id);
            }else {
                $arrInsert['image_name'] = $image_data['file_name'];
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                $status = $this->model->saveAll($arrInsert);
            }
            if ($status) {
                $this->session->set_flashdata('message', 'Image Maping Added Successfully !!');
                redirect('manage/image_maping/add_child/' . $maped_event_image_id);
            } else {
                $this->session->set_flashdata('message', 'Failed to Add Image Maping !!');
                redirect('manage/image_maping/add_child/' . $maped_event_image_id);
            }
            //add_chil end*****************
            if ($status) {
                $this->session->set_flashdata('message', 'Image Maping Added Successfully !!');
                redirect('manage/image_maping/add_child/' . $maped_event_image_id);
            } else {
                $this->session->set_flashdata('message', 'Failed to Add Image Maping !!');
                redirect('manage/image_maping/add_child/' . $maped_event_image_id);
            }
        }
        $search = "";
        $field = "";
        $arrData['list'] = $this->model->getAll($maped_event_image_id, '1', $search, $field, 'image_map.id', 'AND');
        $event_id = $arrData['list']->event_id;
        $arrData['exhhibitor_list'] = $this->attendee_model->getAll(NULL, NULL, 'E', array('attendee.attendee_type'), 'AND', '', $event_id);
        $exhibitor_list_data = array();
        $ii = 0;
        foreach ($arrData['exhhibitor_list'] as $ex_value) {
            if ($ex_value['api_access_token'] !== '') {
                $exhibitor_list_data[$ii] = $ex_value;
                $ii++;
            }
        }
        $arrData['exhhibitor_list'] = $exhibitor_list_data;
        $arrData['thisPage'] = 'Default Event Map';
        $arrData['breadcrumb'] = ' Event Map';
        $arrData['breadcrumb_tag'] = ' Description for Event Map goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $arrData['middle'] = 'admin/image_maping/add_child';
        $this->load->view('admin/default', $arrData);
    }

    function get_exhibitor($maped_event_image_id = NULL) {
        $map_id = $this->input->post('map_id');
        $event_id = $this->input->post('event_id');
        $coordinates = $this->input->post('coordinates');
        $this->db->where('image_map.parent_id', $map_id);
        $this->db->where('image_map.event_id', $event_id);
        $this->db->where('image_map.child_coords', $coordinates);
        $image_map_result = $this->db->get('image_map')->row();
        if (!empty($image_map_result)) {
            echo json_encode($image_map_result);
        } else {
//            $this->db->where('map_exhibitor.map_id', $map_id);
//            $this->db->or_where('map_exhibitor.child_map_id', $map_id);
            $where = '(map_exhibitor.map_id="' . $map_id . '" or map_exhibitor.child_map_id = "' . $map_id . '")';
            $this->db->where($where);
            $this->db->where('map_exhibitor.event_id', $event_id);
            $this->db->where('map_exhibitor.coordinates', $coordinates);
            $result = $this->db->get('map_exhibitor')->row();
            if (!empty($result)) {
                $fields = array('exhibitor.event_id');
                $search = $event_id;
                $result->exhhibitor_list = $this->exhibitor_model->getAll(NULL, NULL, $search, $fields, NULL, NULL, NULL);
                $exhibitor_list_data = array();
                $ii = 0;
                foreach ($result->exhhibitor_list as $ex_value) {
//                    if ($ex_value['contact_gcm_reg_id'] !== '') {
                    $exhibitor_list_data[$ii] = $ex_value;
                    $ii++;
//                    }
                }
                $result->exhhibitor_list = $exhibitor_list_data;
            }
            echo json_encode($result);
        }
    }

    function get_child_image_map($maped_event_image_id = NULL) {
        $map_id = $this->input->post('map_id');
        $event_id = $this->input->post('event_id');
        $child_coords = $this->input->post('child_coords');

        $where = '(map_exhibitor.map_id="' . $map_id . '" or map_exhibitor.child_map_id = "' . $map_id . '")';
        $this->db->where($where);
        $this->db->where('map_exhibitor.event_id', $event_id);
        $this->db->where('map_exhibitor.coordinates', $child_coords);
        $exhibitor_result = $this->db->get('map_exhibitor')->row();
        if (!empty($exhibitor_result)) {
            $result['exhibitor_response'] = '1';
        } else {
            $this->db->where('image_map.parent_id', $map_id);
            $this->db->where('image_map.event_id', $event_id);
            $this->db->where('image_map.child_coords', $child_coords);
            $result = $this->db->get('image_map')->row();
        }

        echo json_encode($result);
    }

    function delete($map_id) {
        $this->db->where('id', $map_id);
        $this->db->or_where('parent_id', $map_id);
        $this->db->delete('image_map');
        $this->db->where('map_id', $map_id);
        $this->db->delete('map_exhibitor');
        $this->session->set_flashdata('message', 'Image Maping deleted Successfully !!');
        redirect('manage/image_maping/');
    }

    function delete_exhibitor($map_id) {
        $this->db->where('id', $map_id);
        $this->db->delete('map_exhibitor');
        $this->session->set_flashdata('message', 'Image Maping deleted Successfully !!');
        redirect('manage/image_maping/');
    }

}
