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
        //echo 'test commit';
        setcookie("postarray", "", time() - 3600);
//        $this->model->status = array("0", "1");
        $this->model->name = 'image_map.name';
        $search = "";
        $field = "";
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
                if ($this->form_validation->run() == FALSE) {
//                    echo $this->form_validation->display_error();
               echo form_error('name');
               echo form_error('coordinates');
               echo form_error('event_id');
                    echo "error";

                    die;
                } else {
//                    echo $this->form_validation->display_error();
                    echo "not errore";

                    die;
                }
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
        $result = $this->db->get('keywords_detail');
        $arrData['event_list'] = $event_list;
        $arrData['keyword_deatail'] = $result->result_array();
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

    function get_exhibitor($maped_event_image_id = NULL) {
        $map_id = $this->input->post('map_id');
        $event_id = $this->input->post('event_id');
        $coordinates = $this->input->post('coordinates');
        $this->db->where('map_exhibitor.map_id', $map_id);
        $this->db->where('map_exhibitor.event_id', $event_id);
        $this->db->where('map_exhibitor.coordinates', $coordinates);
        $result = $this->db->get('map_exhibitor')->row();
        echo json_encode($result);
    }

    function delete($map_id) {
        $this->db->where('id', $map_id);
        $this->db->delete('image_map');
        $this->db->where('map_id', $map_id);
        $this->db->delete('map_exhibitor');
        $this->session->set_flashdata('message', 'Image Maping deleted Successfully !!');
        redirect('manage/image_maping/');
    }

}
