<?php

class Agenda extends CI_Controller {

    public $event_id;

    function __construct() {

        parent::__construct();

        $this->load->model('session_model', 'model');
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
        $this->load->model('speaker_model');

        $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
    }

    function index($passTrack = NULL) {
        if (!is_numeric($passTrack))
            $passTrack = NULL;
        $where = 'event_id  = ' . $this->event_id;
        $arrList = array();
        $arrTracks = $this->model->getTracks($where);
        if (!empty($arrTracks)) {
            $arrData['track_selected'] = $track_id = $arrTracks[0]['id'];
            $where = 'event_id  = ' . $this->event_id . ' AND track_id = ' . $track_id;
            $arrList = $this->model->getAll($where);
            if ($this->input->post('track_id')) {
                $track_id = $this->input->post('track_id');
                $arrData['track_selected'] = $track_id;
                $where = 'event_id  = ' . $this->event_id . ' AND track_id = ' . $track_id;
                $arrList = $this->model->getAll($where);
            } elseif (!is_null($passTrack)) {
                $arrData['track_selected'] = $track_id = $passTrack;
                $where = 'event_id  = ' . $this->event_id . ' AND track_id = ' . $track_id;
                $arrList = $this->model->getAll($where);
            }
        }
        //get event 
        $arrData['event'] = $event = $this->event_model->getAll($this->event_id, TRUE);

//        echo current_url();exit;

        $strtoStartTime = strtotime($event->event_start);
        $arrData['year'] = date('Y', $strtoStartTime);
        $arrData['month'] = date('m', $strtoStartTime);
        $arrData['day'] = date('d', $strtoStartTime);
        $start_date = date('Y-m-d', $strtoStartTime);
        $strtoEndTime = strtotime($event->event_end);
        $end_date = date('Y-m-d', $strtoEndTime);

        //set next and prev as per event start date
        $arrData['next'] = date('Y-m-d', strtotime($event->event_start . ' + 1 days'));
        $arrData['prev'] = date('Y-m-d', strtotime($event->event_start . ' - 1 days'));
        $arrData['active_date'] = date('Y-m-d', strtotime($event->event_start));

        if (get_cookie('current_day')) {
            $strtoStartTime = strtotime(get_cookie('current_day'));
            $arrData['year'] = date('Y', $strtoStartTime);
            $arrData['month'] = date('m', $strtoStartTime);
            $arrData['day'] = date('d', $strtoStartTime);
//            $start_date = date('Y-m-d', $strtoStartTime);
//            $strtoEndTime = strtotime($event->event_end);
//            $end_date = date('Y-m-d', $strtoEndTime);
            //set next and prev as per event start date
            $arrData['next'] = date('Y-m-d', strtotime(get_cookie('current_day') . ' + 1 days'));
            $arrData['prev'] = date('Y-m-d', strtotime(get_cookie('current_day') . ' - 1 days'));
            $arrData['active_date'] = date('Y-m-d', strtotime(get_cookie('current_day')));
        }
        if ($this->input->post('next')) {
            $next = $this->input->post('next_date');
            if ($next > $end_date) { // if post date next is greater than end date set start date
                $arrData['year'] = date('Y', $strtoStartTime);
                $arrData['month'] = date('m', $strtoStartTime);
                $arrData['day'] = date('d', $strtoStartTime);

                //set next and prev as per event start date
                $arrData['next'] = date('Y-m-d', strtotime($event->event_start . ' + 1 days'));
                $arrData['prev'] = date('Y-m-d', strtotime($event->event_start . ' - 1 days'));
                $arrData['active_date'] = date('Y-m-d', strtotime($event->event_start));
            } else {
                $arrData['year'] = date('Y', strtotime($next));
                $arrData['month'] = date('m', strtotime($next));
                $arrData['day'] = date('d', strtotime($next));

                //set next and prev as per posted date
                $arrData['next'] = date('Y-m-d', strtotime($next . ' + 1 days'));
                $arrData['prev'] = date('Y-m-d', strtotime($next . ' - 1 days'));
                $arrData['active_date'] = date('Y-m-d', strtotime($next));
            }
        }
        if ($this->input->post('prev')) {
            $prev = $this->input->post('prev_date');
            if ($prev < $start_date) {
                $arrData['year'] = date('Y', $strtoEndTime);
                $arrData['month'] = date('m', $strtoEndTime);
                $arrData['day'] = date('d', $strtoEndTime);

                //set next and prev as per event start date
                $arrData['next'] = date('Y-m-d', strtotime($event->event_end . ' + 1 days'));
                $arrData['prev'] = date('Y-m-d', strtotime($event->event_end . ' - 1 days'));
                $arrData['active_date'] = date('Y-m-d', strtotime($event->event_end));
            } else {
                $arrData['year'] = date('Y', strtotime($prev));
                $arrData['month'] = date('m', strtotime($prev));
                $arrData['day'] = date('d', strtotime($prev));

                //set next and prev as per posted date
                $arrData['next'] = date('Y-m-d', strtotime($prev . ' + 1 days'));
                $arrData['prev'] = date('Y-m-d', strtotime($prev . ' - 1 days'));
                $arrData['active_date'] = date('Y-m-d', strtotime($prev));
            }
        }
//        echo '<pre style="float:right">';
//        var_dump($arrData['active_date']);
//        echo '</pre>';

        $arrData['list'] = $arrList;
//        echo '<pre>';print_r($arrData);exit;
        $arrEvent = array();
        foreach ($arrList as $event) {
            $arrEvent[] = array('session_id' => $event['id'],
                'title' => $event['name'],
                'name' => $event['name'],
                'speaker_id' => $event['speaker_id'],
                'description' => $event['description'],
                'start' => $event['start_time'],
                'event_id' => $event['event_id'],
                'track_id' => $event['track_id'],
                'session_date' => $event['session_date'],
                'end' => $event['end_time'],
                'image' => ($event['upload'] != '') ? base_url() . UPLOAD_SESSION_PHOTO_DISPLAY . $event['upload'] : 'http://placehold.it/106x64',
                'allDay' => FALSE);
        }
        setcookie('current_day', $arrData['active_date']);
        //echo '<pre>';print_r($arrList);exit;
        $arrSpeaker = $this->speaker_model->getDropdownValuesForEvent(NULL, FALSE);
        $arrData['speakers'] = $arrSpeaker;
        $arrData['tracks'] = $arrTracks;
        $arrData['events'] = $arrEvent;
        $arrData['thisPage'] = 'Agenda';
        $arrData['Agenda'] = '1';
        $arrData['breadcrumb'] = ' Agenda';
        $arrData['breadcrumb_tag'] = ' ----';
        $arrData['breadcrumb_class'] = 'fa-flask';
        $arrData['middle'] = 'admin/agenda/index';
        $this->load->view('admin/default', $arrData);
    }

    function addtrack() {
        $arrInsert = $this->input->post();

        $this->model->saveTrack($arrInsert);
        return true;
        ;
    }

    function addSession($json = 'no') {
        $arrInsert = $this->input->post();

        if (isset($arrInsert['session_title']))
            $arrInsert['name'] = $arrInsert['session_title'];

        if (isset($arrInsert['session_startF']))
            $arrInsert['start_time'] = $arrInsert['session_startF'];

        if (!isset($arrInsert['event_id']))
            $arrInsert['event_id'] = $this->event_id;

        if (isset($arrInsert['session_endF']))
            $arrInsert['end_time'] = $arrInsert['session_endF'];

        if (isset($arrInsert['session_des']))
            $arrInsert['description'] = $arrInsert['session_des'];

        if (isset($arrInsert['session_id'])) {
            if ($arrInsert['session_id'] != '')
                $arrInsert['id'] = $arrInsert['session_id'];
        }

        if ($_FILES['upload']['name'] != '') {
            $config = array(
                "upload_path" => UPLOAD_SESSION_PHOTO,
                "allowed_types" => 'gif|jpg|png|jpeg|pdf|doc|docx',
                "max_size" => '3072',
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('upload')) {
                $data[] = $this->upload->display_errors();
                $this->session->set_flashdata('message', 'Error In uploading file');
                redirect('manage/agenda/index/' . $arrInsert['track_id']);
            } else {
                $arrInsert['upload'] = $this->upload->file_name;
            }
        }
        if (isset($arrInsert['id'])) {

            $id = $arrInsert['id'];
            if ($id == '')
                $id = NULL;
            unset($arrInsert['id']);
        } else {
            $id = NULL;
            $arrInsert['session_date'] = $arrInsert['start_time'];
        }
        $session_id = $this->model->save($arrInsert, $id);
        $i = 0;
        if (isset($arrInsert['speaker_id'])) {
            $arrTags = array();
            foreach ($arrInsert['speaker_id'] as $speaker_id) {
                $arrTags[$i]['session_id'] = $session_id;
                $arrTags[$i]['attendee_id'] = $speaker_id;
                $arrTags[$i]['pvt_org_id'] = getPrivateOrgId();
                $arrsession_hs_speaker[$i]['session_id'] = $session_id;
                $arrsession_hs_speaker[$i]['speaker_id'] = $speaker_id;
                $arrsession_hs_speaker[$i]['pvt_org_id'] = getPrivateOrgId();
                $i++;
            }
            $this->has_model->tableName = 'session_has_attendee';
            if (!is_null($id)) {
                $arrHasDelete = array("session_id" => $session_id);

                if (!$this->has_model->delete($arrHasDelete))
                    $error = TRUE;
            }
            $this->has_model->save($arrTags);
            $this->has_model->tableName = 'session_has_speaker';
            if (!is_null($id)) {
                $arrHasDelete = array("session_id" => $session_id);
                if (!$this->has_model->delete($arrHasDelete))
                    $error = TRUE;
            }
            $this->has_model->save($arrsession_hs_speaker);
        }
        if ($json == 'json')
            echo json_encode($session_id);
        else {
            redirect('manage/agenda/index/' . $arrInsert['track_id']);
        }
        ;
    }

    function deleteTrack() {
        $arrDelete = $this->input->post();
        $this->model->deleteTrack($arrDelete);
        return true;
        ;
    }

    function deleteSession($id = NULL) {
        if (is_null($id))
            redirect('manage/agenda');

        $arrData = array('id' => $id);
        $this->db->where($arrData);
        $this->db->delete('session');
//        echo $this->db->last_query();exit;
        redirect('manage/agenda');

        ;
    }

}
