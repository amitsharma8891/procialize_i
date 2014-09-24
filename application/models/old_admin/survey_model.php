<?php

class survey_model extends CI_Model {

    function __construct() {
        // Initialization of class
        parent::__construct();
        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
        //$this->load->database();
    }

    public $event_id;
    public $status = array("1");
    public $order_by = 'ASC';
    public $order_name = 'survey.id';
    public $fields = array(
        "id",
        "name",
        "url",
        "event_id",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "pvt_org_id",
        "exhibitor",
        "attendee",
    );

    /**
     * generate_fields
     *
     * generates form field elements
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  null
     * @return  void
     */
    function generate_fields($id = NULL) {
        $superadmin = $this->session->userdata('is_superadmin');
        $arrResult = array();
        if (!is_null($id)) {
            $arrResult = $this->getAll($id, TRUE);
           
        }
        

        $arrData['fields'] = array();
        $arrData['fields'] = array(
            'event_id' => array(
                "type" => "hidden",
                //"event_id" => isset($this->event_id) ? $this->event_id : '',
                "event_id" => isset($arrResult->event_id) ? $arrResult->event_id : '',
            ),
            'name' => array("name" => "name",
                "type" => "text",
                "id" => "name",
                "class" => "form-control",
                "placeholder" => "Name",
                "validate" => 'required|trim',
                "error" => 'Name',
                "value" => set_value('name', (isset($arrResult->name) ? $arrResult->name: $this->input->post('name'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-12"
                    ),
					array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Name</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'url' => array("name" => "url",
                "type" => "text",
                "id" => "url",
                "class" => "form-control",
                "placeholder" => "Survey Url",
                "validate" => 'required|trim',
                "error" => 'Survey Url',
                "value" => set_value('url', (isset($arrResult->url) ? $arrResult->url : $this->input->post('url'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-12"
                    ),
					array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Survey Url</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'attendee_id' => array("name" => "attendee_id[]",
                "type" => "dropdown",
                "id" => "industry_id",
                "attributes" => ' multiple data-placeholder="Attendee"',
                "class" => "form-control chosen-select",
                "placeholder" => "attendee_id",
                "validate" => '',
                "error" => 'Industry',
                "options" => getAttendee_dropdown(),
                "value" => set_value('attendee_id', $this->input->post('attendee_id')),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
					array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Attendee</div>',
                        "position" => "prependElement",
                    ),
                ),
            ),
            'now' => array("name" => "now",
                "type" => "checkbox",
                "id" => "type_of_answer",
                "class" => "pull-left",
                "error" => 'Type of Answer',
                "label" => 'Now',
                "placeholder" => array('now' => "now"),
                "checked" => set_value('now', $this->input->post('type_of_answer')),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group duplicate",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-1"
                    ),
                ),
            ),
            'date' => array("name" => "date",
                "type" => "text",
                "id" => "datepicker-general",
                "class" => "form-control x",
                "placeholder" => "Date",
                "validate" => '',
                "error" => '',
                "value" => set_value('date', (isset($arrResult->date) ? $arrResult->date : $this->input->post('date'))),
                "decorators" => array(
                   
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-4"
                    ),
                ),
            ),
            'time' => array("name" => "time",
                "type" => "text",
                "id" => "time",
                "class" => "form-control time-picker ui-timepicker-inputs",
                "placeholder" => "Time",
                "validate" => '',
                "error" => '',
                "value" => set_value('url', (isset($arrResult->time) ? $arrResult->time : $this->input->post('time'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-4"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "close",
                        "class" => "form-group",
                    ),
                ),
            ),
            'type_of_user' => array("name" => "type_of_user ",
                "type" => "checkbox",
                "id" => "type_of_answer",
                "class" => "pull-left",
                "error" => 'Type of Answer',
                "label" => 'Type of Answer',
                //"placeholder" => array('All' => "All", 'E' => "Exhibitor", 'A' => "Attendee/Speaker"),
				"placeholder" => array('All' => "All Attendee, Speakers, Exhibitors"),
                "checked" => set_value('type_of_answer', (isset($arrResult->type_of_answer) ? $arrResult->type_of_answer : $this->input->post('type_of_answer'))),
                "decorators" => array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "form-group duplicate",
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-12"
                    ),
                ),
            ),
        );
        if ($superadmin) {
            $arrData['fields']['event_id'] = array("name" => "event_id",
                "type" => "dropdown",
                "id" => "event_id",
                "class" => "form-control chosen-select",
                "attributes" => '  data-placeholder="Select Events" ',
                "placeholder" => "Events",
                "options" => $this->event_model->getDropdownValues(),
                "validate" => 'required',
                "error" => 'Event',
               // "value" => set_value('event_id'),
                "value" => isset($arrResult->event_id) ? $arrResult->event_id : '',
                "decorators" => array(
                    array("tag" => "div",
                        "close" => "true",
                        "class" => "form-group"
                    ),
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
					array(
                        "tag" => "lable",
                        "close" => "false",
                        "class" => "col-sm-1 control-label form-label-placeholder",
                        "content" => '<div>Events</div>',
                        "position" => "prependElement",
                    ),
                ),
            );
        }

//        echo '<pre>';print_r($arrData);
//                exit();
        if (isset($id)) {
            $arrData['action'] = base_url() . 'manage/survey/edit/' . $id;
        } else {
            $arrData['action'] = base_url() . 'manage/survey/add';
        }
        $arrData['fileUpload'] = true;
        $arrData['attributes'] = array('id' => 'form1', 'name' => 'form1', 'role' => 'form');
        return $arrData;
    }

    /**
     * saveAll
     *
     * saves entire information of event
     * 
     * @author  Aatish Gore 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function saveAll($data, $id = NULL) {
        $error = FALSE;
        try {
//            $this->db->trans_begin();
            $survey_id = $this->save($data, $id);
            $data['survey_id'] = $survey_id;
            $data['start_time'] = '0000-00-00 ' . $data['start_time'];
            $no_of_question = count($data['question']);
            for ($i = 0; $i < $no_of_question; $i++) {
                $arrData = array();
                $arrData['survey_id'] = $survey_id;
                $arrData['event_id'] = $data['event_id'];
                if ($i == 0)
                    $arrData['type_of_answer'] = $data['type_of_answer'][0];
                else
                    $arrData['type_of_answer'] = $data['type_of_answer' . $i][0];

                if ($data['question'][$i] != '') {
                    $arrData['question'] = $data['question'][$i];

                    $question_id = $this->survey_question_model->save($arrData, $id);
                    print_r($data);
                    for ($j = 1; $j < 5; $j++) {
                        $arrAnswer = array();
                        $arrAnswer['survey_question_id'] = $question_id;
                        $arrAnswer['answer'] = $data['option' . $j][$i];
                        print_r($arrAnswer);
                        if (is_null($id))
                            $this->survey_answer_model->save($arrAnswer);
                        else
                            $this->survey_answer_model->save($arrAnswer, $question_id);
                    }
                }
            }
            if (isset($data['assign_user'])) {
                $arrTags = array();
                $arrTags[0]['survey_id'] = $survey_id;
                $arrTags[0]['event_id'] = $data['event_id'];
                $arrTags[0]['assign_user'] = implode(',', $data['assign_user']);
                $this->has_model->tableName = 'event_has_survey';
                if (!is_null($id)) {
                    $arrHasDelete = array("survey_id" => $survey_id);

                    if (!$this->has_model->delete($arrHasDelete))
                        $error = TRUE;
                }
                $this->has_model->save($arrTags);
            }
        } catch (Exception $e) {
            $error = true;
        }
//        if ($error) {
//            $this->db->trans_rollback();
//        } else {
//            $this->db->trans_commit();
//        }

        return !$error;
    }

    /**
     * save
     *
     * saves exhibitor
     * 
     * @author  Rohan 
     * @access  public
     * @params  array $data 
     * @params  int $id 
     * @return  void
     */
    function save($data, $id = NULL) {
        
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields))
                $arrData[$key] = (isset($data[$key])) ? $data[$key] : '';
        }
        if (!isset($arrData['status']))
            $arrData['status'] = 1;

        if (is_null($id)) {
            $arrData['created_by'] = getCreatedUserId();
            $arrData['created_date'] = date("Y-m-d H:i:s");
            $arrData['pvt_org_id'] = getPrivateOrgId();
            $result = $this->db->insert('survey', $arrData);
            $id = $this->db->insert_id();
        } else {
            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            $this->db->where('id', $id);
            $result = $this->db->update('survey', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

    /**
     * get
     *
     * gets events
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function get($id = NULL, $row = FALSE) {

        if (!is_null($id))
            $this->db->where('id', $id);

        $this->db->where_in('status', $this->status);
        if ($row) {
            $result = $this->db->get('survey')->row();
            return $result;
        } else {
            $result = $this->db->get('survey');

            return $result->result_array();
        }
    }

    /**
     * getAll
     *
     * gets all events
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function getAll($id = NULL, $row = FALSE, $search = NULL, $fields = array(), $type = 'LIKE') {

        if (!is_null($id))
            $this->db->where('survey.id', $id);

//        $this->db->select("survey.*", false);
        $this->db->where_in('survey.status', $this->status);
        //$this->db->order_by($this->order_name, $this->order_by);
        if ($search == 'NULL') {
            $this->db->order_by('survey.created_date', 'desc');
        } else {
            $this->db->order_by($this->order_name, $this->order_by);
        }
        if (!(is_null($search)) && !empty($fields)) {
            foreach ($fields as $field) {
                if ($type == 'LIKE') {
                    $where = "$field LIKE '%$search%'";
                    $this->db->or_where($where);
                } else if ($type == 'AND') {

                    $this->db->where($field, $search);
                } else if ($type = 'or') {
                    $this->db->or_where($field, $search);
                }
            }
        }
////        $this->db->join('survey_question', 'survey_question.survey_id = survey.id');
//        $this->db->join('event_has_survey', 'event_has_survey.survey_id = survey.id', 'left');

        if ($row) {
            $result = $this->db->get('survey')->row();

            return $result;
        } else {
            $result = $this->db->get('survey');

            return $result->result_array();
        }
    }

    /**
     * savePhoto
     *
     * gets all events
     * 
     * @author  Aatish Gore
     * @access  public
     * @params  int $id
     * @params  boolean $row to return single row
     * @return  void
     */
    function savePhoto(&$data, $form) {
        foreach ($form['fields'] as $element) {

            if ($element['type'] == 'file' && $_FILES[$element['name']]['name'] != '') {
                $config = $element['upload_config'];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($element['name'])) {
                    $data = $this->upload->display_errors();
                    return false;
                } else {
                    $data[$element['name']] = $this->upload->file_name;
                    return true;
                }
            }
        }
    }

    /**
     * getDropdownValues
     *
     * gets event dropdown values
     * 
     * @author  Aatish Gore
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

    function createAnswer($arrAnswer = array(), $i = 1, &$arrData) {

        $k = 1;
        if ($i == '')
            $j = 1;
        else
            $j = rand();
        foreach ($arrAnswer as $answer) {
            if ($k % 2 == 0) {
                $arrDec = array(
                    array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ), array(
                        "tag" => "div",
                        "close" => "close",
                        "class" => "form-group ",
                    )
                );
            } else {
                $arrDec = array(
                    array(
                        "tag" => "div",
                        "close" => "false",
                        "class" => "form-group ",
                    ), array(
                        "tag" => "div",
                        "close" => "true",
                        "class" => "col-sm-6"
                    ),
                );
            }


            $arrAns = array("name" => "option" . $k . "[]",
                "type" => "text",
                "id" => "option" . $j,
                "class" => "form-control",
                "placeholder" => "Option",
                "validate" => '',
                "error" => 'option2',
                "value" => set_value('option2', (isset($answer['answer']) ? $answer['answer'] : '')),
                "decorators" => $arrDec,
            );

            $arrData['fields']['option' . $j] = $arrAns;
            $k++;
            $j++;
        }
    }

    function createQuestion($question = array(), $i = 1, $arrData) {

        $k = 1;
        if ($i == '')
            $j = '';
        else
            $j = rand();

        $arrQuestion = array(
            "name" => "question[]",
            "type" => "text",
            "id" => "question" . $j,
            "class" => "form-control",
            "placeholder" => "Question",
            "validate" => 'required',
            "error" => 'Description',
            "value" => set_value('question', (isset($question['question']) ? $question['question'] : '')),
            "decorators" => array(
                array(
                    "tag" => "div",
                    "close" => "true",
                    "class" => "form-group duplicate",
                ),
                array(
                    "tag" => "div",
                    "close" => "true",
                    "class" => "col-sm-10"
                ),
                array(
                    "tag" => "div",
                    "close" => "true",
                    "class" => "col-sm-1 add-Element",
                    "content" => "Add",
                    "position" => "appendElement",
                ),
            ),
        );

        $arrData['fields']['question' . $j] = $arrQuestion;

        $arrTOA = array("name" => "type_of_answer" . $i . "[]",
            "type" => "radio",
            "id" => "type_of_answer",
//                "class" => "form-control",
            "error" => 'Type of Answer',
            "label" => 'Type of Answer',
            "placeholder" => array('M' => "Multiple Options", 'R' => "Radio Button", 'T' => "User Entry"),
            "checked" => set_value('type_of_answer', (isset($question['type_of_answer']) ? $question['type_of_answer'] : '')),
            "decorators" => array(
                array(
                    "tag" => "div",
                    "close" => "true",
                    "class" => "form-group duplicate",
                ),
                array(
                    "tag" => "div",
                    "close" => "true",
                    "class" => "col-sm-12"
                ),
            ),
        );
        $arrData['fields']['type_of_answer' . $i] = $arrTOA;
    }

    /**
     * delete
     *
     * delete  
     * @author  Rohan
     * @access  public
     * @param array $arrData,Integer $id
     * @return  array
     */
    function delete($arrData) {

        $this->db->where_in('id', $arrData);
        if ($this->db->delete('survey')) {
            return true;
        } else {
            return false;
        }
    }

    function check_unique($data,$event_id,$id=NULL) {
        //echo $event_id.'<pre>'; print_r($data); exit;
        $this->db->select('count(*) as count');
        $this->db->where('name',$data);
        $this->db->where('event_id',$event_id);
        if($id) {
            $this->db->where('id',$id);
        }
        $result_set = $this->db->get('survey');
        $result = $result_set->result_array();
        //echo $this->db->last_query();
        //echo '<pre>'; print_r($result); exit;
        if($id) {
         if($result[0]['count'] == 1) {
            return TRUE;
         }   
        } else {
            if($result[0]['count'] == 0) {
                return TRUE;
            } else {
                return FALSE;
            }    
        }
    }
}

?>
