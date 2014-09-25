<?php

class Exhibitor extends CI_Controller {

    public $event_id = 20;

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

        $this->load->model('exhibitor_model', 'model');
        $this->load->model('industry_model');
        $this->load->model('functionality_model');
        $this->load->model('event_model');
        $this->load->model('tag_relation_model');
        $this->load->model('tag_model');
        $this->load->model('has_model');
        $this->load->model('organizer_model');
        $this->load->model('user_model');
        $this->load->model('exhibitor_profile_model');
        $this->load->model('attendee_model');
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
    public function index($order = 1) {
        //echo 'here'; exit;
//        print_r($this->session->all_userdata());exit;
        setcookie("postarray", "", time() - 3600);

        $this->model->status = array("0", "1");
        $this->model->order_name = 'exhibitor.name';

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
//            echo $selected_event;

            if ($this->input->post('event_drpdown') == 0 && $this->input->post('send_passcode') == '' && $this->input->post('search') == '') {
                if ($selected_event) {
                    $search = $selected_event;
                    $drop_down_search = $selected_event;
                    $field = array("exhibitor.event_id");
                    $this->model->status = array("0", "1");
                    $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
                }
            }
        }
//              display($selected_event );
//
//        die;



        $type = $this->session->userdata('type_of_user');
        $superadmin = $this->session->userdata('is_superadmin');

        if ($type == 'E' && !$superadmin)
            redirect('manage/index');
        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif ($order == 2) {
            $this->model->order_name = 'exhibitor.is_featured';
            $this->model->order_by = 'DESC';
        }

        if ($order == 3) {

            $search = 0;
            $drop_down_search = $selected_event;
            $field = array("exhibitor.mail_sent");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'exhibitor.id', 'AND', $drop_down_search);
        } elseif ($order == 4) {
            $search = '1';
             $drop_down_search = $selected_event;
            
            $field = array("exhibitor.mail_sent");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'exhibitor.id', 'AND', $drop_down_search);
        } else {
            $search = $selected_event;
            $drop_down_search = $selected_event;
//            echo "dfdsfsdfsd" . $selected_event . "gggggggggggggggggggg";
            $field = array("exhibitor.event_id");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        }

        if ($this->input->post()) {

            if ($this->input->post('send_mail') != '') {
                $status = $this->model->sendMail($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Mail sent successfully');
                    redirect('manage/exhibitor');
                } else {
                    $this->session->set_flashdata('message', "Main not sent to one or more people due to invalid email address. Please select 'Sort by' as 'Mail not Sent' and find out the result. ");
                    redirect('manage/exhibitor');
                }
            }
            if ($this->input->post('delete') && $this->input->post('send_mail') == '') {
                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Exhibitor Deleted');
                    redirect('manage/exhibitor');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Delete Exhibitor');
                    redirect('manage/exhibitor');
                }
            }
            if ($this->input->post('search') != '' && $this->input->post('send_mail') == '') {
                $search = $this->input->post('search');
                $field = array("exhibitor.name", "user2.first_name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
//                echo $this->db->last_query();exit;
            }

            if ($this->input->post('event_drpdown') != '' && $this->input->post('send_mail') == '' && $this->input->post('search') == '') {
                $search = $selected_event;
                $drop_down_search = $selected_event;
                $field = array("exhibitor.event_id");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
//                echo $this->db->last_query();exit;
            }
        }
//                            echo $this->db->last_query();exit;
//        print_r($arrData);exit;
        $arrData['selected_event'] = $selected_event;
        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
        $arrData['thisPage'] = 'Default Exhibitor';
        $arrData['breadcrumb'] = 'Exhibitor';
        $arrData['breadcrumb_tag'] = ' Description for exhibitor goes here';
        $arrData['breadcrumb_class'] = 'fa-home';
//        echo '<pre>';print_r($arrData);exit;
        $arrData['middle'] = 'admin/exhibitor/index';
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
            $arrInsert = $this->input->post();
            $postarray = json_encode($arrInsert);
            setcookie('postarray', $postarray);

            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $event = $this->input->post('event_id');
                $name = $this->input->post('name');
                $city = $this->input->post('city');
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);
                $check_unique = $this->model->check_unique($name, $city, $event, $id = null);
                if ($check_unique) {
                    $this->session->set_flashdata('message', 'Exhibitor with same name, city and Event found !!');
                    redirect('manage/exhibitor');
                } else {
                    if ($_FILES['logo']['name'] != '' || $_FILES['floor_plan']['name'] != '' || $_FILES['brochure']['name'] != '' || $_FILES['image2']['name'] != '' || $_FILES['image1']['name'] != '') {

                        $upload_status = $this->model->savePhoto($arrInsert, $fields);
                        if (!$upload_status) {
                            $this->session->set_flashdata('message', $arrInsert[0]);
                            redirect('manage/exhibitor/add');
                        }
                    }
                    $arrInsert['top_level_id'] = getTopLevelId();
                    $arrInsert['created_by'] = getCreatedUserId();
                    $arrInsert['created_date'] = date("Y-m-d H:i:s");
                    $status = $this->model->saveAll($arrInsert);
                    if ($status) {
                        $this->session->set_flashdata('message', 'Exhibitor Added Successfully !!');
                        redirect('manage/exhibitor');
                    } else {
                        $this->session->set_flashdata('message', 'Failed to Add Exhibitor!!');
                        redirect('manage/exhibitor/add');
                    }
                }
            } else {
                redirect('manage/exhibitor/add');
            }
        }
//        $arrData['thisPage'] = 'Default Exhibitor';
//        $arrData['breadcrumb'] = 'Exhibitor';
//        $arrData['middle'] = 'admin/exhibitor/add';
//        $arrData['middle'] = 'admin/middle_template';
//       
//        $this->load->view('admin/default',$arrData);
        $arrData['thisPage'] = 'Add Exhibitor';
        $arrData['breadcrumb'] = 'Add Exhibitor';
        $arrData['breadcrumb_tag'] = ' All elements to add an Exhibitor..';
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
        // echo $id; 
        $arrData['fields'] = $fields = $this->model->generate_fields($id);

        $arrData['fields']['fields']['username']['readonly'] = 'readonly';
        $arrData['fields']['fields']['username']['validate'] = 'required';
        $arrData['fields']['fields']['password']['validate'] = '';
        $arrData['fields']['fields']['password']['class'] = 'form-control';
        $arrData['fields']['fields']['name']['validate'] = 'required|trim';
        $arrData['fields']['fields']['name']['readonly'] = 'readonly';
        $user_type = $this->session->userdata('type_of_user');
        if ($user_type == 'E') {
            unset($arrData['fields']['fields']['is_featured']);
        }
        //print_r($arrData); exit;

        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert = $this->input->post();
                //echo '<pre>'; print_r($arrInsert); exit;
                /* if($arrInsert['contact_email'] != '') {
                  $table = 'exhibitor';
                  $duplicate = $this->user_model->check_duplicate_email($arrInsert['contact_email'],$table,$id);
                  if($duplicate) {
                  $this->session->set_flashdata('message', 'Encountered with Duplicate Email id');
                  redirect('manage/exhibitor/edit/'.$id);
                  }
                  } */

                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                // print_r($arrInsert);
                $event = $this->input->post('event_id');
                $name = $this->input->post('name');
                $city = $this->input->post('city');
                $email = $this->input->post('contact_email');
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);

                $check_unique = $this->model->check_unique($name, $city, $event, $id);
                if ($check_unique) {
                    $this->session->set_flashdata('message', 'Exhibitor with same name, city and Event found !!');
                    redirect('manage/exhibitor');
                } else {

                    if ($this->model->object->contact_email != $email) {
                        $arrCheck['email'] = $email;
                        $check_attendee = $this->attendee_model->check_attendee($arrCheck);
                        if ($check_attendee != FALSE) {
                            $this->session->set_flashdata('message', 'Contact Email already exist!!');
                            redirect('manage/exhibitor/edit/' . $id);
                        }
                    }
                    if (isset($_FILES)) {
                        if ($_FILES['logo']['name'] != '' || $_FILES['floor_plan']['name'] != '' || $_FILES['brochure']['name'] != '' || $_FILES['image2']['name'] != '' || $_FILES['image1']['name'] != '') {

                            $upload_status = $this->model->savePhoto($arrInsert, $fields);
                            if (!$upload_status) {
                                $this->session->set_flashdata('message', $arrInsert[0]);
                                redirect('manage/exhibitor/edit/' . $id);
                            }
                        }
                    }

//                    $arrInsert = array_filter($arrInsert, "removeBlank");
                    //                echo '<pre>';print_r($arrInsert);exit;
                    if (!isset($arrInsert['password']))
                        unset($arrInsert['password']);
                    else {
                        if ($arrInsert['password'] == '')
                            unset($arrInsert['password']);
                    }

                    $status = $this->model->saveAll($arrInsert, $id);
                    if ($status) {
                        setcookie("postarray", "", time() - 3600);
                        $this->session->set_flashdata('message', 'Exhibitor Edited Successfully !!');
                        redirect('manage/exhibitor');
                    } else {
                        $this->session->set_flashdata('message', 'Failed to Edit Exhibitor!!');
                        redirect('manage/exhibitor/edit/' . $id);
                    }
                }
            }
        }

        $arrData['thisPage'] = 'Default Exhibitor';
        $arrData['breadcrumb'] = 'Edit Exhibitor';
        $arrData['breadcrumb_tag'] = ' All elements to edit an Exhibitor..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/middle_template';
        $arrData['data'] = $this->model->getAll($id, true);
//      
        $this->load->view('admin/default', $arrData);
    }

    function import() {
        if (isset($_FILES['file'])) {
            $csv_file = $_FILES['file']['tmp_name'];
            if (!is_file($csv_file)) {
                $this->session->set_flashdata('message', 'File not found.');

                redirect('manage/exhibitor');
            }
            $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            if (!in_array($_FILES['file']['type'], $mimes)) {
                // do something
                $this->session->set_flashdata('message', 'Only .csv file type is allowed.');

                redirect('manage/exhibitor');
            }
            # intialize your counters for successful and failed record imports 
            $pass = 0;
            $fail = 0;
            $arrLabel = array(
                0 => 'name',
                1 => 'description',
                2 => 'industry_id',
                3 => 'functionality_id',
                4 => 'city',
                5 => 'country',
                6 => 'is_featured',
                7 => 'status',
                8 => 'tag',
                9 => 'contact_first_name',
                10 => 'contact_last_name',
                11 => 'contact_phone',
                12 => 'contact_email',
                13 => 'contact_mobile',
                14 => 'stall_number',
                15 => 'website_link',
                16 => 'username',
                17 => 'password',
            );
            $arrInsert = array();
            $arrSkip = array();
            $arrError = array();
            $i = 0;
            $insertValues = 0;
            if (($handle = fopen($csv_file, "r")) !== FALSE) {
                $l = 0;
                $lineNo = 1;

                while (($line = fgetcsv($handle)) !== FALSE) {

                    if ($l == 0) { //skip first row for col names
                        $l++;
                        continue;
                    }
                    $skip = false;

                    foreach ($line as $key => $val) {
                        $csvLIneNo = $lineNo + 1;
                        $validate_data = $this->validateRowCSV($line[$key], $key, $arrError[$csvLIneNo]);
                        if ($validate_data)
                            $skip = true;
                        else


                        if ($arrLabel[$key] == 'industry_id') {
                            if (trim($line[$key]) != '') {
                                $arrInsert[$i][$arrLabel[$key]] = $this->industry_model->checkSave(explode(',', trim($line[$key])));
                                continue;
                            }
                        }
                        if ($arrLabel[$key] == 'functionality_id') {
                            if (trim($line[$key]) != '') {
                                $arrInsert[$i][$arrLabel[$key]] = $this->functionality_model->checkSave(explode(',', trim($line[$key])));
                                continue;
                            }
                        }
                        $arrInsert[$i][$arrLabel[$key]] = trim($line[$key]);
                    }
                    if ($skip) {
                        $arrSkip[$lineNo] = $arrInsert[$i];
                        unset($arrInsert[$i]);
                    } else {
                        $this->saveExhibitor($arrInsert[$i]);
                        unset($arrError[$lineNo]);
                        $insertValues++;
                    }
                    $i++;
                    $lineNo++;
                }
            }
//            echo '<pre>';print_r($arrError);exit;
            $arrData['middle'] = 'admin/exhibitor/error';
            $arrData['error'] = $arrError;
            $arrData['insertValues'] = $insertValues;
            $this->session->set_flashdata('message', 'Error in importing csv');
            $arrData['thisPage'] = 'Default Exhibitor';
            $arrData['breadcrumb'] = 'Import Exhibitor';
            $arrData['breadcrumb_tag'] = ' All elements to import an Exhibitor..';
            $arrData['breadcrumb_class'] = 'fa-flask';
//            $arrData['middle'] = 'admin/middle_template';
            $this->load->view('admin/default', $arrData);
        }
    }

    function saveExhibitor($insert) {
        $id = NULL;
        $insert['top_level_id'] = getTopLevelId();
        $insert['event_id'] = $this->event_id;
        $arrCheck['city'] = $insert['city'];
        $arrCheck['country'] = $insert['country'];
        $arrCheck['event_id'] = $this->event_id;
        $arrCheck['name'] = $insert['name'];
        $insert['industry_id'] = $insert['industry_id'];
        $insert['functionality_id'] = $insert['functionality_id'];
        $insert['tag_name'] = $insert['tag'];
        $insert['username'] = $insert['username'] . '_' . $this->event_id;
        if (isset($insert['status'])) {
            if ($insert['status'] == '')
                $insert['status'] = 1;
        }else {
            $insert['status'] = 1;
        }

        if (isset($insert['is_featured'])) {
            if ($insert['is_featured'] == '')
                $insert['is_featured'] = 0;
        }else {
            $insert['is_featured'] = 0;
        }
//        die('adf');
        $id = $this->model->check_exhibitor($arrCheck);
//        echo $this->db->last_query();
//        exit;
        if (!$id)
            $id = NULL;
//                    echo '<pre>';print_r($insert);exit;
        $this->model->saveAllOverwrite($insert, $id);
        return true;
    }

    function delete($json = 'noJson') {
        $arrResult = array();

        if ($this->input->post('id')) {
            $status = $this->model->delete($this->input->post('id'));
            if ($status) {
                $arrResult['status'] = TRUE;
                $arrResult['message'] = 'Exhibitor Deleted';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Exhibitor Deleted';
            }
        }
        if ($json = 'json') {
            echo json_encode($arrResult);
            exit;
        }
    }

    function validateRowCSV($value = NULL, $key = '', &$arrError = array()) {
        if (is_null($value))
            return true;
        $error = false;
        $arrCompuslary = array(
            0,
            4,
            5,
            12,
            17,
            18,
        );
        $arrLabel = array(
            0 => 'name',
            1 => 'description',
            2 => 'industry_id',
            3 => 'functionality_id',
            4 => 'city',
            5 => 'country',
            6 => 'is_featured',
            7 => 'status',
            8 => 'tag',
            9 => 'contact_first_name',
            10 => 'contact_last_name',
            11 => 'contact_phone',
            12 => 'contact_email',
            13 => 'contact_mobile',
            14 => 'stall_number',
            15 => 'website_link',
            16 => 'username',
            17 => 'password',
        );

        if ($key == 13) {
            $error = $this->csvFieldValueRegex('mobile', $value, $key); //for mobile no validation 
        }
        if ($key == 11) {
            $error = $this->csvFieldValueRegex('phone', $value, $key); //for mobile no validation 
        }

        if ($key == 12) {
            $error = $this->csvFieldValueRegex('email', strtolower($value), $key); //for email validation
        }

        if ($error) {
            $arrError [] = $arrLabel[$key];
            return TRUE;
        }

        if (in_array($key, $arrCompuslary)) {
            if ($value == '' || is_null($value)) {
                $arrError [] = $arrLabel[$key];
                return true;
            }
        }

        return false;
    }

    function downloadSample() {

        /*$file = IMAGE_BASEPATH . '/uploads/csv_sample/Exhibitor Upload_Sample.csv';
        header('Content-Type: text/csv');
        header("Content-Disposition:attachment;filename=Exhibitor_Upload_Template.csv");
        header('Pragma: no-cache');
        header("Content-Length: " . filesize($file));
        header("Content-Transfer-Encoding: binary");
        ob_clean();
        flush();
        echo readfile($file);
        exit;*/
        $this->load->helper('download');
        $data = file_get_contents(UPLOADS."csv_sample/Exhibitor_Upload_Sample.csv"); // Read the file's contents
        $name = 'Exhibitor_Upload_Sample.csv';
        force_download($name, $data);
    }

    function csvFieldValueRegex($type, $value, $key) {
        switch ($type) {
            case 'mobile':
                $pattern = '/^\d{10}$/';
                $pattern = '/^(?:\((\+?\d+)?\)|\+?\d+) ?\d*(-?\d{2,3} ?){0,4}$/';
//                $pattern = '/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/';
                break;
            case 'phone':
                $pattern = '/^\d+$/';
                break;
            case 'email':
                $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                break;
            case 'alpha':
                break;
        }
        if ($value == '')
            return FALSE;
        if (!preg_match($pattern, $value)) {
            return TRUE;
        }
    }

}

/* End of file top_level.php */
    /* Location: ./application/controllers/admin/top_level.php */    