<?php

/*
 * To change this template, choose Tools "Templates
 * and open the template in the editor.
 */

/**
 * Description of event_feedback_model
 *
 * @author AATISH
 */
class Event_feedback_model extends CI_Model {

    public $fields = array(
        "id",
        "star",
        "total",
        "status",
        "created_by",
        "created_date",
        "modified_by",
        "modified_date",
        "pvt_org_id",
        "event_id"
    );

    /**
     * save
     *
     * saves sponsor
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

            $result = $this->db->insert('event_feedback', $arrData);
            $id = $this->db->insert_id();
        } else {

            $arrData['modified_by'] = getCreatedUserId();
            $arrData['modified_date'] = date("Y-m-d H:i:s");
            //echo '<pre>'; print_r($arrData); exit;
            $this->db->where('id', $id);
            $result = $this->db->update('event_feedback', $arrData);
        }
        if ($result) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>
