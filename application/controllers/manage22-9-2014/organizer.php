<?php

class Organizer extends CI_Controller {

    public $superadmin = false;

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
        $this->load->model('organizer_model', 'model');
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->superadmin = $this->session->userdata('is_superadmin');
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
//        print_r($this->session->all_userdata());exit;
        $this->model->status = array("0", "1");
        $this->model->order_name = 'organizer.name';

        $type = $this->session->userdata('type_of_user');

        if ($type == 'O' && !$this->superadmin)
            redirect('manage/index');
        if ($order === 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'organizer.id';
            $this->model->order_by = 'DESC';
        }
        if ($order == 3) {
            $search = 0;
            $field = array("mail_sent");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'organizer.id', 'AND');
        } elseif ($order == 4) {
            $search = '1';
            $field = array("mail_sent");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'organizer.id', 'AND');
        } else {
            $arrData['list'] = $this->model->getAll();
        }

        if ($this->input->post()) {
            if ($this->input->post('send_mail') != '') {
//            print_r($this->input->post());exit;
                $status = $this->model->sendMail($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Mail sent successfully');
                    redirect('manage/organizer');
                } else {
                    $this->session->set_flashdata('message', "Main not sent to one or more people due to invalid email address. Please select 'Sort by' as 'Mail not Sent' and find out the result. ");
                    redirect('manage/organizer');
                }
            }
            if ($this->input->post('delete') && $this->input->post('send_mail') == '') {


                $arrResult = array();
                $message = 'Organizer Deleted ';
                $status = true;
                $i = 0;
                foreach ($this->input->post('delete') as $delete_id) {
                    $org = $this->model->getAll($delete_id, true);
                    if ($org->event_id == '')
                        $status = $this->model->delete($delete_id);
                    else {
                        if ($i == 0) {
                            $message = '';
                            $i++;
                        }
                        $status = false;
                        $message .= $org->name . ' cannot be deleted , since it is associated with an event ';
                    }
                }

                $this->session->set_flashdata('message', $message);
                redirect('manage/organizer');
            }
            if ($this->input->post('search') != '') {
                $search = $this->input->post('search');
                $field = array("organizer.name", "user.first_name", "user.last_name");
                $this->model->status = array("0", "1");
                //echo $search; exit;
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
//                echo $this->db->last_query();exit;
            }

            if ($this->input->post('event_drpdown') != '' && $this->input->post('send_mail') == '' && $this->input->post('search') == '') {
                $search = $this->input->post('event_drpdown');
                $field = array("event.id");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'organizer.id', 'AND');
//                echo $this->db->last_query();exit;
            }
        }

        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = ' Organizer';
        $arrData['breadcrumb_tag'] = ' Description for organizer goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
//        $arrData['organizers'] = $this->model->getAll();
        $arrData['middle'] = 'admin/organizer/index';
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
        $this->form_validation->set_message('is_unique', 'This Organizer already exists. Please enter unique Organizer name');
        $arrData['fields'] = $fields = $this->model->generate_fields();
        $arrData['fields']['fields']['name']['validate'] = 'is_unique[organizer.name]';
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);

            if ($this->form_validation->run() === TRUE) {
                if ($_FILES['organiser_photo']['name'] != '') {

                    $upload_status = $this->model->savePhoto($arrInsert, $fields);
                    if (!$upload_status) {
                        $this->session->set_flashdata('message', $arrInsert[0]);
                        redirect('manage/organizer/add');
                    }
                } else {
                    $this->session->set_flashdata('message', 'Logo is required');
                    redirect('manage/organizer/add');
                }
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);

                $arrInsert['pvt_org_id'] = getPrivateOrgId();
                $arrInsert['top_level_id'] = getPrivateOrgId();
                $arrInsert['organizer_id'] = getOrganizerId();
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrInsert['type_of_user'] = 'O';
                $status = $this->model->saveAll($arrInsert);
                if ($status) {
                    $this->session->set_flashdata('message', 'Organizer Added Successfully !!');
                    redirect('manage/organizer');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add Organizer!!');
                    redirect('manage/organizer/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Create Organizer';
        $arrData['breadcrumb_tag'] = ' All elements to add an Organizer...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/organizer/add';
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
        //  echo '../../'.UPLOAD_ORGANIZER_LOGO; exit;
        if (is_null($id))
            redirect('manage/organizer/add');
        $arrData['fields'] = $fields = $this->model->generate_fields($id);
        $arrData['fields']['fields']['password']['validate'] = '';
        $arrData['fields']['fields']['password']['class'] = 'form-control';
        $arrData['fields']['fields']['username']['readonly'] = true;
        $arrData['fields']['fields']['cpassword']['validate'] = 'validate[equals[password]]';
        $arrData['fields']['fields']['cpassword']['class'] = 'form-control';
        $arrData['fields']['fields']['email']['validate'] = '';

        //$arrData['fields']['fields']['email']['readonly'] = true;
        if ($this->input->post()) {
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);

            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                // echo $_FILES['organiser_photo']['name'];
                //echo "<br>";
                // echo '<pre>'; print_r($arrInsert); exit;
                //echo "<br>";
                if ($arrInsert['email'] != '' && $this->model->object->email != $arrInsert['email']) {
                    $table = 'organizer';
                    $duplicate = $this->user_model->check_email($arrInsert['email']);
                    if ($duplicate) {
                        $this->session->set_flashdata('message', 'Email id Already exists');
                        redirect('manage/organizer/edit/' . $id);
                    }
                }

                if ($_FILES['organiser_photo']['name'] != '') {
                    $upload_status = $this->model->savePhoto($arrInsert, $fields);
                    //print_r($upload_status); exit;
                    if (!$upload_status) {
                        $this->session->set_flashdata('message', $arrInsert[0]);
                        redirect('manage/organizer/edit/' . $id);
                    }
                }
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);

                $arrInsert['pvt_org_id'] = getPrivateOrgId();
                $arrInsert['organizer_id'] = getOrganizerId();
                if ($arrInsert['password'] == '')
                    unset($arrInsert['password']);
                //  echo '<pre>'; print_r($arrInsert); //exit;
                $status = $this->model->saveAll($arrInsert, $id);

                if (getTypeUser() == 'O' && !$this->superadmin) {
                    $this->session->set_flashdata('message', 'Organizer Updated Successfully !!');
                    redirect('manage/index');
                }
                if ($status) {
                    $this->session->set_flashdata('message', 'Organizer Updated Successfully !!');
                    redirect('manage/organizer');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Update Organizer!!');
                    redirect('manage/organizer/edit/' . $id);
                }
            }
        }
        $arrData['thisPage'] = 'Default Organizer';
        $arrData['breadcrumb'] = 'Edit Organizer';
        $arrData['breadcrumb_tag'] = ' All elements to edit an Organizer...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/organizer/add';
        $this->load->view('admin/default', $arrData);
    }

    /**
     * getDropdownValues
     *
     * gets industry dropdown values
     * 
     * @author  Rohan
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getDropdownValues($id = NULL) {
        $dropDownValues = $this->get();

        $arrDropdown = array();
        foreach ($dropDownValues as $value) {
            $arrDropdown[$value['id']] = $value['name'];
        }
        return $arrDropdown;
    }

    function delete($json = 'noJson') {

        $arrResult = array();
        $message = 'Organizer Deleted';
        $status = true;
        if ($this->input->post('id')) {
            $delete_id = $this->input->post('id');
//            foreach ($this->input->post('id') as $delete_id) {
            $org = $this->model->getAll($delete_id, true);
            if ($org->event_id == '')
                $status = $this->model->delete($delete_id);
            else {
                $status = false;
                $message = $org->name . ' cannot be deleted , since it is associated with an event ';
            }
//            }
            $arrResult['status'] = $status;
            $arrResult['message'] = $message;
        }
        if ($json = 'json') {
            echo json_encode($arrResult);
            exit;
        }
    }

    function add_edit($id = NULL) {
        $is_superadmin = $this->session->userdata('is_superadmin');
        $user_id = $this->session->userdata('user_id');
        $type_of_user = $this->session->userdata('type_of_user');
        if (!$is_superadmin) {
            if ($type_of_user == 'O') {
                $this->db->select('id');
                $this->db->where('organizer.user_id', $user_id);
                $arrData_org_id = $this->db->get('organizer')->row();
                if ($arrData_org_id->id && empty($id) || $arrData_org_id->id != $id) {
                    redirect('manage/organizer/add_edit/' . $arrData_org_id->id);
                }
            } else {
                redirect('manage/index');
            }
        }

        $arrData['thisPage'] = 'Default Organizer';
        if ($id) {
            $arrData['breadcrumb'] = 'Edit Organizer';
        } else {
            $arrData['breadcrumb'] = 'Add Organizer';
        }
        $arrData['breadcrumb_tag'] = ' All elements to edit an Organizer...';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/organizer/add';

        $is_superadmin = $this->superadmin;
        if ($id || $is_superadmin) {
            if ($is_superadmin && empty($id)) {
                $superadmin_user_id = $this->session->userdata('user_id');
                $this->db->where_in('organizer.user_id', $superadmin_user_id);
            } else {
                $this->db->where_in('organizer.id', $id);
            }
            $this->db->join('user', 'user.id = organizer.user_id');
            $arrData['list'] = $this->db->get('organizer')->row();
        }
        $this->load->view('admin/default', $arrData);
    }

    function validate_organizer() {
        $arrInsert = $this->input->post(NULL, TRUE);
        if (empty($arrInsert['user_id'])) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[organizer.name]');
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
                if (!$this->superadmin) {
                    $this->form_validation->set_rules('current_password', 'Current Password', 'required');
                    $curent_pass_result = $this->model->checkcurrentPass(md5($this->input->post('current_password')), $arrInsert['user_id']);
                    if (!$curent_pass_result) {
                        $json_array['current_pass'] = 'not_match';
                        $json_array['error'] = 'error';
                    } else {
                        $json_array['current_pass'] = 'match';
                    }
                }
            }
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
        }
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');

        if ($this->form_validation->run() == False) {
            $json_array['error'] = 'error';
            $json_array['name_err'] = form_error('name');
            $json_array['first_name_err'] = form_error('first_name');
            $json_array['username_err'] = form_error('username');
            $json_array['email_err'] = form_error('email');
            $json_array['password_err'] = form_error('password');
            $json_array['passconf_err'] = form_error('cpassword');
        } else {
            if ($this->input->post()) {
                if (!isset($json_array['current_pass']) || $json_array['current_pass'] == 'match') {
                    if (!isset($json_array['email']) || $json_array['email'] == 'email_match') {
                        $arrInsert = $this->input->post(NULL, TRUE);
                        $id = $this->input->post('user_id');
                        $arrInsert['created_by'] = getCreatedUserId();
                        $arrInsert['created_date'] = date("Y-m-d H:i:s");
                        $arrInsert['top_level_id'] = '1';
                        $arrInsert['pvt_org_id'] = '1';
                        $arrInsert['type_of_user'] = 'O';
                        unset($arrInsert['current_password']);
                        $status = $this->model->save_org($id, $arrInsert);
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

    /**
     * img save to file
     *
     * edit user
     * 
     * @author  Anupam
     * @access  public
     * @params  null
     * @return  void
     */
    function img_save_to_file() {
        $imagePath = UPLOADS.'organizer/logo/';

        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
        $temp = explode(".", $_FILES["img"]["name"]);
        $extension = end($temp);

        if (in_array($extension, $allowedExts)) {
            if ($_FILES["img"]["error"] > 0) {
                $response = array(
                    "status" => 'error',
                    "message" => 'ERROR Return Code: ' . $_FILES["img"]["error"],
                );
                echo "Return Code: " . $_FILES["img"]["error"] . "<br>";
            } else {

                $filename = $_FILES["img"]["tmp_name"];
                list($width, $height) = getimagesize($filename);

                move_uploaded_file($filename, $imagePath . $_FILES["img"]["name"]);

                $response = array(
                    "status" => 'success',
                    "url" => SITE_URL . 'uploads/organizer/logo/' . $_FILES["img"]["name"],
                    "width" => $width,
                    "height" => $height,
                    "upload_image_name" => $_FILES["img"]["name"]
                );
            }
        } else {
            $response = array(
                "status" => 'error',
                "message" => 'something went wrong'
            );
        }

        print json_encode($response);
        //$this->load->view('admin/manage/organizer/img_save_to_file.php');
    }

    /**
     * img crop to file
     *
     * edit user
     * 
     * @author  Anupam
     * @access  public
     * @params  null
     * @return  void
     */
    function img_crop_to_file() {

        /*
         * 	!!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
         */
//        print_r($_POST);
        $imgUrl = $_POST['imgUrl'];
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
        $cropW = $_POST['cropW'];
        $cropH = $_POST['cropH'];
        $jpeg_quality = 100;
        $random = rand();
        $output_filename = UPLOADS.'organizer/logo/crop_' . $random;
        $what = getimagesize($imgUrl);
        switch (strtolower($what['mime'])) {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }
        $resizedImage = imagecreatetruecolor($imgW, $imgH);
        imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
//        echo $cropW."ljdgskfgksdgfhgds".$cropH;
        $dest_image = imagecreatetruecolor($cropW, $cropH);
        imagecopyresampled($dest_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
        imagejpeg($dest_image, $output_filename . $type, $jpeg_quality);
        $output_filename = SITE_URL . 'uploads/organizer/logo/crop_' . $random;
        $response = array(
            "status" => 'success',
            "url" => $output_filename . $type,
            "crop_image_name" => 'crop_' . $random . $type
        );
        print json_encode($response);
    }

}
