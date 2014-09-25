<?php

class Attendee extends CI_Controller {

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
        $this->load->model('attendee_model', 'model');
        $this->load->model('exhibitor_model');
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
        $this->load->helper('admin_emailer');
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
    public function index($order = NULL) {
        $this->model->attendee_type = array('A');
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
//        $this->load->library('manage_pagination');
//        $per_page = 3;
//        $current_page = $this->uri->segment(3, 0);
//        $limit['per_page'] = $per_page;
//        if ($current_page <= 0)
//            $limit['current_page'] = $current_page * $per_page;
//        else
//            $limit['current_page'] = ($current_page - 1) * $per_page;
//        $arrData['total_list'] = $this->model->getAll(NULL, FALSE, $search = NULL, $field = array());
//
//        $this->model->limit = $limit['per_page'];
//        $this->model->offset = $limit['current_page'];

        if ($order == 0) {
            $this->model->order_by = 'ASC';
        } elseif ($order == 1) {
            $this->model->order_by = 'DESC';
        } elseif (is_null($order)) {
            $this->model->order_name = 'attendee.id';
            $this->model->order_by = 'DESC';
        }

        if ($order == 3) {
            $search = 0;
            $drop_down_search = $selected_event;
            $field = array("event_has_attendee.mail_sent");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        } elseif ($order == 4) {
            $search = '1';
            $drop_down_search = $selected_event;
            $field = array("event_has_attendee.mail_sent");
//            $drop_down_field = array("event_has_attendee.event_id");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        } else {
            $search = $selected_event;
            $drop_down_search = $selected_event;
//            echo "dfdsfsdfsd" . $selected_event . "gggggggggggggggggggg";
            $field = array("event_has_attendee.event_id");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        }

        if ($order == 5) {
            $search = 1;
            $drop_down_search = $selected_event;
            $field = array("event_has_attendee.approve_by_org");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        } else if ($order == 6) {
            $search = 0;
            $drop_down_search = $selected_event;
            $field = array("event_has_attendee.approve_by_org");
            $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
        }

        if ($this->input->post()) {
            if ($this->input->post('send_passcode') && $this->input->post('search') == '') {
//                echo '<pre>';
//                print_r($this->input->post('delete'));
//                exit;

                $status = $this->model->sendPasscode($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Mail sent successfully');
                    redirect('manage/attendee');
                } else {
                    $this->session->set_flashdata('message', "Main not sent to one or more people due to invalid email address. Please select 'Sort by' as 'Mail not Sent' and find out the result. ");
                    redirect('manage/attendee');
                }
            }

            if ($this->input->post('delete') && !($this->input->post('send_passcode')) && $this->input->post('event_drpdown') == 0) {

                $status = $this->model->delete($this->input->post('delete'));
                if ($status) {
                    $this->session->set_flashdata('message', 'Attendee Deleted Successfully');
                    redirect('manage/attendee');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Deleted Attendee');
                    redirect('manage/attendee');
                }
            }

            if ($this->input->post('search') != '') {
                $search = $this->input->post('search');
                $field = array("attendee.name", "user.first_name");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field);
            }


            if ($this->input->post('event_drpdown') != 0 && $this->input->post('send_passcode') == '' && $this->input->post('search') == '') {
                $selected_event = $this->input->post('event_drpdown');
                $search = $this->input->post('event_drpdown');
                $drop_down_search = $selected_event;
                $field = array("event_has_attendee.event_id");
                $this->model->status = array("0", "1");
                $arrData['list'] = $this->model->getAll(NULL, FALSE, $search, $field, 'AND', '', $drop_down_search);
//                echo $this->db->last_query();exit;
            }
        } else {

//
//            #########Pagination- amit#######
//            $this->manage_pagination->arr_data = $arrData['total_list'];
//            $this->manage_pagination->offset = $current_page; //$limit['current_page'];
//            $this->manage_pagination->url = 'manage/attendee/';
//            $this->manage_pagination->setup_pagination();
//            $arrData['pagination'] = $this->manage_pagination->strpagination;
        }
//        echo $selected_event;
//        die;
//        display($this->input->post());
//        echo $this->input->post('event_drpdown');
//        echo $selected_event;
//        die;
//        show_query();
        $arrData['selected_event'] = $selected_event;
        $arrData['event_dropdown'] = $this->event_model->getDropdownValues(NULL, true);
//        echo '<pre>'; print_r($arrData['event_dropdown']);exit;
        $arrData['breadcrumb'] = 'Attendee';
        $arrData['breadcrumb_tag'] = ' Description for attendee goes here';
        $arrData['breadcrumb_class'] = 'fa-home';

        $arrData['middle'] = 'admin/attendee/index';
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
                $arrInsert = $this->input->post();
                //echo '<pre>'; print_r($arrInsert); exit;
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);

                if (isset($_FILES)) {
                    if ($_FILES['photo']['name'] != '') {
                        $upload_status = $this->model->savePhoto($arrInsert, $fields);
                        if (!$upload_status) {
                            $this->session->set_flashdata('message', $arrInsert[0]);
                            redirect('manage/attendee/add');
                        }
                    }
                }

                $arrInsert['name'] = $arrInsert['first_name'] . ' ' . $arrInsert['last_name'];
                $arrInsert['top_level_id'] = getTopLevelId();
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrCheck['email'] = $arrInsert['email'];
                $attendee_exist_id = $this->model->check_attendee($arrCheck);

                if (!$attendee_exist_id) {
                    $attendee_exist_id = NULL;
                } else {
                    $arrInsert = array_filter($arrInsert, "removeBlank");
                }

                $status = $this->model->saveAll($arrInsert, $attendee_exist_id);
                if ($status) {
                    setcookie("postarray", "", time() - 3600);
                    $this->session->set_flashdata('message', 'Attendee Added Successfully !!');
                    redirect('manage/attendee');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add attendee!!');
                    redirect('manage/attendee/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Attendee';
        $arrData['breadcrumb'] = 'Add Attendee';
        $arrData['breadcrumb_tag'] = ' All elements to add an Attendee..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/attendee/add';
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
        // echo $id; exit;
        // echo "<br>";
        // echo '<pre>'; print_r($this->model->generate_fields($id)); exit;
        // echo "<br>";
        $arrData['fields'] = $fields = $this->model->generate_fields($id);
        //$arrData['fields']['fields']['phone']['validate'] = 'required|regex_match[/^[0-9]+$/]|';
        //$arrData['fields']['fields']['mobile']['validate'] = 'required|regex_match[/^[0-9]+$/]|';
        $arrData['fields']['fields']['email']['validate'] = 'required|trim';

        if ($this->input->post()) {

            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                // echo '<pre>'; print_r($arrData); exit;
                $arrInsert = $this->input->post();
                // echo '<pre>'; print_r($arrInsert); exit;
                if ($this->model->object->email != $arrInsert['email']) {
                    $arrCheck['email'] = $arrInsert['email'];
                    $check_attendee = $this->model->check_attendee($arrCheck);
                    if ($check_attendee != FALSE) {
                        $this->session->set_flashdata('message', 'Attendee Email already exist!!');
                        redirect('manage/attendee/edit/' . $id);
                    }
                }

                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                unset($arrInsert['btnSave']);
                unset($arrInsert['cpassword']);

                if (isset($_FILES)) {
                    if ($_FILES['photo']['name'] != '') {
                        $upload_status = $this->model->savePhoto($arrInsert, $fields);
                        if (!$upload_status) {
                            $this->session->set_flashdata('message', $arrInsert[0]);
                            redirect('manage/attendee/edit/' . $id);
                        }
                    }
                }
                $arrInsert['top_level_id'] = getTopLevelId();
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrInsert['name'] = $arrInsert['first_name'] . ' ' . $arrInsert['last_name'];
                //echo '<pre>'; print_r($arrInsert); exit;
                $status = $this->model->saveAll($arrInsert, $id);
                //echo '<pre>'; print_r($status); exit;
                if ($status) {
                    $this->session->set_flashdata('message', 'Attendee Updated Successfully !!');
                    redirect('manage/attendee');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Update attendee!!');
                    redirect('manage/attendee/add');
                }
            }
        }
        $arrData['thisPage'] = 'Default Exhibitor';
        $arrData['breadcrumb'] = 'Edit Attendee';
        $arrData['breadcrumb_tag'] = ' All elements to Edit an Attendee..';
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
                $arrResult['message'] = 'Attendee Deleted';
            } else {
                $arrResult['status'] = false;
                $arrResult['message'] = 'Attendee Deleted';
            }
        }
        if ($json = 'json') {
            echo json_encode($arrResult);
            exit;
        }
    }

    function import() {
        if (isset($_FILES['file'])) {
            $csv_file = $_FILES['file']['tmp_name'];
            if (!is_file($csv_file)) {
                $this->session->set_flashdata('message', 'File not found.');

                redirect('manage/attendee');
            }

            $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            if (!in_array($_FILES['file']['type'], $mimes)) {
                // do something
                $this->session->set_flashdata('message', 'Only .csv file type are allowed.');

                redirect('manage/attendee');
            }
            # intialize your counters for successful and failed record imports 
            $pass = 0;
            $fail = 0;

            $arrLabel = array(
                0 => 'first_name',
                1 => 'last_name',
                2 => 'industry',
                3 => 'functionality',
                4 => 'city',
                5 => 'country',
                6 => 'company_name',
                7 => 'designation',
                8 => 'description',
                9 => 'status',
                10 => 'tag',
                11 => 'phone',
                12 => 'email',
                13 => 'mobile',
                14 => 'website',
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


                        if (@$arrLabel[$key] == 'industry') {
                            if (trim($line[$key]) != '') {
                                $arrInsert[$i][$arrLabel[$key]] = $this->industry_model->checkSave(explode(',', trim($line[$key])));
                                continue;
                            }
                        }
                        if (@$arrLabel[$key] == 'functionality') {
                            if (trim($line[$key]) != '') {
                                $arrInsert[$i][$arrLabel[$key]] = $this->functionality_model->checkSave(explode(',', trim($line[$key])));
                                continue;
                            }
                        }
                        @$arrInsert[$i][$arrLabel[$key]] = trim($line[$key]);
                    }
                    if ($skip) {
                        $arrSkip[$lineNo] = $arrInsert[$i];
                        unset($arrInsert[$i]);
                    } else {
                        unset($arrError[$lineNo]);
//                        echo '<pre>';print_r($arrInsert[$i]);exit;
                        $this->SaveAttendee($arrInsert[$i]);
                        $insertValues++;
                    }
                    $i++;
                    $lineNo++;
                }
            }
            $arrData['middle'] = 'admin/exhibitor/error';
            $arrData['error'] = $arrError;
            $arrData['insertValues'] = $insertValues;
            $this->session->set_flashdata('message', 'Error in importing csv');
            $arrData['thisPage'] = 'Default Attendee';
            $arrData['breadcrumb'] = 'Import Attendee';
            $arrData['breadcrumb_tag'] = ' All elements to import an Attendee..';
            $arrData['breadcrumb_class'] = 'fa-flask';
//                $arrData['middle'] = 'admin/middle_template';
            $this->load->view('admin/default', $arrData);
        }
    }

    function SaveAttendee($insert) {
        $id = NULL;
        $insert['top_level_id'] = getTopLevelId();
        $insert['event_id'] = $this->event_id;
        $arrCheck['first_name'] = $insert['first_name'];
        $arrCheck['last_name'] = $insert['last_name'];
        $arrCheck['email'] = $insert['email'];
        $insert['industry_id'] = $insert['industry'];
        $insert['tag_name'] = $insert['tag'];
        $insert['functionality_id'] = $insert['functionality'];
        $insert['name'] = $insert['first_name'] . ' ' . $insert['last_name'];
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
        $insert['attendee_type'] = 'A';
        $id = $this->model->check_attendee($arrCheck);
//        echo '<pre>';print_r($insert);exit;
        if (!$id)
            $id = NULL;
        $this->model->saveAllOverwrite($insert, $id);
    }

    function validateRowCSV($value = NULL, $key = '', &$arrError = array()) {
        $error = '';
        if (is_null($value))
            return true;
        $arrCompuslary = array(
            0, //firstname 
            12 //email
        );


        $arrLabel = array(
            0 => 'first_name',
            1 => 'last_name',
            2 => 'industry',
            3 => 'functionality',
            4 => 'city',
            5 => 'country',
            6 => 'company_name',
            7 => 'designation',
            8 => 'description',
            9 => 'status',
            10 => 'tag',
            11 => 'phone',
            12 => 'email',
            13 => 'mobile',
            14 => 'website',
        );

        if ($key == 11) {
            $error = $this->csvFieldValueRegex('phone', $value, $key); //for mobile no validation 
        }
        if ($key == 13) {
            $error = $this->csvFieldValueRegex('mobile', $value, $key); //for mobile no validation 
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
        /*echo $file = IMAGE_BASEPATH . '/uploads/csv_sample/Attendee_Upload_Sample.csv';
        header('Content-Type: text/csv');
        header("Content-Disposition:attachment;filename=Attendee_Upload_Template.csv");
        header('Pragma: no-cache');
        header("Content-Length: " . filesize($file));
        header("Content-Transfer-Encoding: binary");
        ob_clean();
        flush();

        echo readfile($file);
        exit;*/
        $this->load->helper('download');
        $data = file_get_contents(UPLOADS."csv_sample/Attendee_Upload_Sample.csv"); // Read the file's contents
        $name = 'Attendee_Upload_Sample.csv';
        force_download($name, $data);
    }

    /*
     * to check for a perticilar pattrn of string
     *      */

    function csvFieldValueRegex($type, $value, $key) {
        switch ($type) {
            case 'mobile':
                $pattern = '/^\d{10}$/';
                $pattern = '/^(?:\((\+?\d+)?\)|\+?\d+) ?\d*(-?\d{2,3} ?){0,4}$/';
                //$pattern = '/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/';
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
    function quick() {

        $arrData['fields'] = $fields = $this->model->generate_fields_quick();
        if ($this->input->post()) {
            formVaidation($arrData['fields'], $this);
            if ($this->form_validation->run() === TRUE) {
                $arrInsert = $this->input->post();
                $postarray = json_encode($arrInsert);
                setcookie('postarray', $postarray);
                unset($arrInsert['btnSave']);
                $arrInsert['name'] = $arrInsert['first_name'] . ' ' . $arrInsert['last_name'];
                $arrInsert['top_level_id'] = getTopLevelId();
                $arrInsert['created_by'] = getCreatedUserId();
                $arrInsert['created_date'] = date("Y-m-d H:i:s");
                $arrCheck['email'] = $arrInsert['email'];
                $attendee_exist_id = $this->model->check_attendee($arrCheck);

                if (!$attendee_exist_id) {
                    $attendee_exist_id = NULL;
                } else {
                    $arrInsert = array_filter($arrInsert, "removeBlank");
                }

                $status = $this->model->saveAll($arrInsert, $attendee_exist_id);
                if ($status) {
                    if (!is_null($this->model->id)) {
                        $arrSend = array($this->model->id);
                        $this->model->sendPasscode($arrSend);
                    }
                    setcookie("postarray", "", time() - 3600);
                    $this->session->set_flashdata('message', 'Attendee Added Successfully !!');
                    redirect('manage/attendee');
                } else {
                    $this->session->set_flashdata('message', 'Failed to Add attendee!!');
                    redirect('manage/attendee/quick');
                }
            }
        }
        $arrData['thisPage'] = 'Default Attendee';
        $arrData['breadcrumb'] = 'Add quick Attendee';
        $arrData['breadcrumb_tag'] = ' All elements to add an Attendee..';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/attendee/add';
        $this->load->view('admin/default', $arrData);
    }

}

/* End of file top_level.php */
/* Location: ./application/controllers/admin/top_level.php */
