<?php

class setting_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();
    }

    function get_setting($top_level_id = '')
    {
        $query = $this->db->select('*')->from('setting')->where('top_level_id',1)->get();
        $result = $query->row();
        return json_encode($result);
    }
    function save_setting($data)
    {
        //display($data['app_slider_image']);
        $table_array = array(
                                //'app_first_name' => $data[''],
                                //'app_last_name' => $data[''],
                                'app_owner_name' => $data['owner_name'],
                                'app_name' => $data['app_name'],
                                'app_company_name' => $data['company_name'],
                                'app_twitter_hash_tag' => $data['twitter_hash_tag'],
                                'app_primary_color' => $data['primary_color'],
                                'app_secondary_color' => $data['secondary_color'],
                                'app_logo_big' => $data['app_logo_image'],
                                'google_play_store' => $data['google_play_store'],
                                'apple_app_store' => $data['apple_app_store'],
                                //'app_logo_small' => $data[''],
                                'app_background_image' => $data['app_background_image'],
                                'app_slider_image' => json_encode($data['app_slider_image']),
                                'app_contact_name' => $data['contact_name'],
                                'app_contact_no' => $data['contact_no'],
                                'app_contact_email' => $data['contact_email'],
                                'app_address' => $data['address'],
                                //'timing' => $data[''],
                                'app_wecome_message' => $data['welcome_message'],
                                //'top_level_id' => 1,//$data[''],
                                //'organizer_id' => $data[''],
                                'date_modified' => date('Y-m-d H:i:s'),
                            );
        $this->db->where('top_level_id',1);
        $this->db->update('setting',$table_array);
    }

}

?>
