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
//        $this->model->status = array("0", "1");
        $this->model->name = 'image_map.name';
//        $search = "0";
//        $field = array('image_map.parent_id');
        $search = "";
        $field = '';
        $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'image_map.id', 'AND');
        $arrData['thisPage'] = 'Default Image Maping';
        $arrData['breadcrumb'] = ' Image Maping';
        $arrData['breadcrumb_tag'] = ' Description for Image Maping goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
//        $arrData['organizers'] = $this->model->getAll();
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
//        echo $id;die;
        $config['upload_path'] = UPLOADS . 'event_image_maping/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $config['quality'] = 100;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
//        $config['width'] = 200;
//        $config['height'] = 200;
        $this->db->select('event.name,event.id');
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
            if (TRUE) {
//                if ($this->form_validation->run() == FALSE) {
////                    echo $this->form_validation->display_error();
//               echo form_error('name');
//               echo form_error('coordinates');
//               echo form_error('event_id');
//                    echo "error";
//
//                    die;
//                } else {
////                    echo $this->form_validation->display_error();
//                    echo "not errore";
//
//                    die;
//                }
                if (!$this->upload->do_upload('image_name')) //{
                    $error = array('error' => $this->upload->display_errors());
//                } else {
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
                    redirect('manage/image_maping');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add Image Maping !!');
                    redirect('manage/image_maping/add');
                }
//                }
            }
        }
        $arrData['event_list'] = $event_list;
        $parent_list = $this->db->where('image_map.parent_id', 0);
        $parent_list = $this->db->get('image_map');
        $parent_list = $parent_list->result_array();
        $arrData['parent_list'] = $parent_list;
        $arrData['list'] = $this->model->get($id);
        $arrData['thisPage'] = 'Default Image Maping';
        $arrData['breadcrumb'] = 'Add Image Maping';
        $arrData['breadcrumb_tag'] = ' All elements to add an Image for an event...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/image_maping/add';
        $this->load->view('admin/default', $arrData);
//        $this->load->view('admin/image_maping/add');
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
            $map_exhibitor_id = $arrInsert['map_exhibitor_id'];
            if ($map_exhibitor_id) {
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
                unset($arrInsert['image_map_id']);
                $status = $this->map_exhibitor_model->saveAll($arrInsert, $map_exhibitor_id);
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
        $event_id = $arrData['list']->event_id;
        $arrData['exhhibitor_list'] = $this->attendee_model->getAll(NULL, NULL, 'E', array('attendee.attendee_type'), 'AND', '', $event_id);
        $arrData['thisPage'] = 'Default Image Maping';
        $arrData['breadcrumb'] = ' Image Maping';
        $arrData['breadcrumb_tag'] = ' Description for Image Maping goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
        $arrData['middle'] = 'admin/image_maping/map_exhibitor';
        $this->load->view('admin/default', $arrData);
    }

    function add_child($maped_event_image_id = NULL) {
//        setcookie("postarray", "", time() - 3600);
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
//            $id = $maped_event_image_id;
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
//                echo "update";
//                display($arrInsert);
//                die;
                $status = $this->model->saveAll($arrInsert, $id);
            }else {
                $arrInsert['image_name'] = $image_data['file_name'];
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $arrInsert['created'] = date("Y-m-d H:i:s");
                $arrInsert['modified'] = date("Y-m-d H:i:s");
//                echo "save";
//                display($arrInsert);
//                die;
                $status = $this->model->saveAll($arrInsert);
            }
            if ($status) {
                $this->session->set_flashdata('message', 'Image Maping Added Successfully !!');
                redirect('manage/image_maping');
            } else {
                $this->session->set_flashdata('message', 'Failed to Add Image Maping !!');
                redirect('manage/image_maping/add');
            }
            //add_chil end*****************
//            if ($map_exhibitor_id) {
//                $postarray = json_encode($arrInsert);
//                setcookie('postarray', $postarray);
//                $arrInsert['created'] = date("Y-m-d H:i:s");
//                $arrInsert['modified'] = date("Y-m-d H:i:s");
//                unset($arrInsert['image_map_id']);
////                $status = $this->map_exhibitor_model->saveAll($arrInsert, $map_exhibitor_id);
//            } else {
//                $postarray = json_encode($arrInsert);
//                setcookie('postarray', $postarray);
//                $arrInsert['created'] = date("Y-m-d H:i:s");
//                $arrInsert['modified'] = date("Y-m-d H:i:s");
//                unset($arrInsert['image_map_id']);
//                $status = $this->map_exhibitor_model->saveAll($arrInsert);
//            }
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
        $arrData['thisPage'] = 'Default Image Maping';
        $arrData['breadcrumb'] = ' Image Maping';
        $arrData['breadcrumb_tag'] = ' Description for Image Maping goes here';
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
            $this->db->where('map_exhibitor.map_id', $map_id);
            $this->db->where('map_exhibitor.event_id', $event_id);
            $this->db->where('map_exhibitor.coordinates', $coordinates);
            $result = $this->db->get('map_exhibitor')->row();
            echo json_encode($result);
        }
    }

    function get_child_image_map($maped_event_image_id = NULL) {
        $map_id = $this->input->post('map_id');
        $event_id = $this->input->post('event_id');
        $child_coords = $this->input->post('child_coords');
//        $this->db->where('map_exhibitor.map_id', $map_id);
//        $this->db->where('map_exhibitor.event_id', $event_id);
//        $this->db->where('map_exhibitor.coordinates', $child_coords);
//        $result = $this->db->get('map_exhibitor')->row();
//        if (!empty($result)) {
//            $result->status = 1;
//            echo json_encode($result);
//        } else {
        $this->db->where('image_map.parent_id', $map_id);
        $this->db->where('image_map.event_id', $event_id);
        $this->db->where('image_map.child_coords', $child_coords);
        $result = $this->db->get('image_map')->row();
//            $result->status = 0;
        echo json_encode($result);
//        }
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

}
