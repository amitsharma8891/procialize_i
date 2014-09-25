<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'Mandrill.php';
/**
 * Procialize
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Procialize
 * @author		Aatish Gore
 * @copyright           Copyright (c) 2013 - 2014.
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Custom form helper
 *
 * @package		JITO
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Aatish Gore
 */
// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
/**
 * getCreatedUserId
 * 
 * returns loggedin user id
 * 
 * @access	public
 * @param	null
 * @return	int 
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getCreatedUserId')) {

    function getCreatedUserId() {
        $ci = & get_instance();
        $user_id = $ci->session->userdata('user_id');
        return $user_id
        ;
    }

}

/**
 * getCreatedUserId
 * 
 * returns loggedin user id
 * 
 * @access	public
 * @param	null
 * @return	int 
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getInstance')) {

    function getInstance() {
        return 1;
    }

}
/**
 * getPvtOrgId
 * 
 * returns loggedin user id orgainsation id
 * 
 * @access	public
 * @param	null
 * @return	int 
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getPvtOrgId')) {

    function getPvtOrgId() {
        return 1;
    }

}
/**
 * stringToArray
 * 
 * returns loggedin user id orgainsation id
 * 
 * @access	public
 * @param	$string
 * @param       $delimiter
 * @return	int 
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('stringToArray')) {

    function stringToArray($string = '', $delimiter = ',') {
        return explode($delimiter, $string);
    }

}

/**
 * saveTags
 * 
 * returns loggedin user id orgainsation id
 * 
 * @access	public
 * @param	$data  array
 * @return	int 
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('saveTags')) {

    function saveTags($data = array()) {
        if (empty($data))
            return;
        $arrRawTags = stringToArray($data['tag_name']);
        $arrTags = array();
        $i = 0;
        $ci = & get_instance();
        $debug = $ci->db->db_debug;
        $ci->db->db_debug = FALSE;

        foreach ($arrRawTags as $tag) {
            $arrTags = array();
            $arrTags['tag_name'] = $tag;
            $arrTags['created_by'] = getCreatedUserId();
            $arrTags['created_date'] = date("Y-m-d H:i:s");
            $arrTags['status'] = 1;
            $i++;
            $ci->db->insert('tag', $arrTags);
        }
        $ci->db->db_debug = $debug;
        return $arrRawTags;
    }

}
/**
 * saveTags
 * 
 * returns loggedin user id orgainsation id
 * 
 * @access	public
 * @param	$data  array
 * @return	int 
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('menuArray')) {

    function menuArray() {
        $menuArray = array(
            'manage/index' => 'Dashboard',
//            'manage/top_level' => 'Top level',
            'manage/organizer' => 'organizer',
            'manage/event' => 'Event Profile',
//            'manage/agenda' => 'agenda',
            'manage/exhibitor' => 'exhibitor',
            'manage/attendee' => 'attendee',
            'manage/sponsor' => 'sponsor',
            'manage/speaker' => 'speaker',
            'manage/survey' => 'survey',
            'manage/industry' => 'industry',
            'manage/functionality' => 'functionality',
//            'manage/tag' => 'tag',
            'manage/email_template' => 'Email template',
        );

        return $menuArray;
    }

}

function allowedMenus($type = '') {
    $arrAllowed = array();

    if ($type == '')
        return $arrAllowed;
    switch ($type) {
        case 'O':
            $menuArray = array(
                'manage/index' => 'Dashboard',
                'manage/event/edit/' => 'Event Profile',
                'manage/agenda' => 'agenda',
                'manage/exhibitor' => 'exhibitor',
                'manage/attendee' => 'attendee',
                'manage/sponsor' => 'sponsor',
                'manage/speaker' => 'speaker',
            );

            break;
        case 'E':
            $menuArray = array(
                'manage/index' => 'Dashboard',
                'manage/exhibitor' => 'exhibitor',
            );
            break;
    }
    return $menuArray;
}

function generateMenu($type, $isAdmin = false) {
    $arrAllMenu = menuArray();
    $menuArray = array();

    if ($isAdmin)
        return $arrAllMenu;
    $arrAllowed = array();
    $ci = & get_instance();
    $is_pvt_app = $ci->session->userdata('is_pvt_id');
    $allow_email_temp_menu = array('#' => 'Announcement');
    if ($is_pvt_app) {
        $allow_email_temp_menu = array('manage/email_template' => 'email_template', '#' => 'Announcement');
    }
    if ($type == '')
        return $menuArray;
    switch ($type) {
        case 'O':
            $menuArray = array(
                'manage/index' => 'Dashboard',
                'manage/event/edit/' => 'Event Profile',
                'manage/agenda' => 'agenda',
                'manage/exhibitor' => 'exhibitor',
                'manage/attendee' => 'attendee',
                'manage/sponsor' => 'sponsor',
                'manage/speaker' => 'speaker',
                'manage/survey' => 'survey',
            );
            $menuArray = array_merge($menuArray, $allow_email_temp_menu);
            break;
        case 'E':
            $menuArray = array(
                'manage/index' => 'Dashboard',
                'manage/exhibitor/edit/' . $ci->session->userdata('id') => 'exhibitor profile',
                '#' => 'Announcement',
            );
            break;
    }
    return $menuArray;
}

function getEvents($user_id = 0, $isAdmin = false, $type = NULL) {
    $arrEvents = array();
    if ($isAdmin) {
        $arrEvents[0]['name'] = 'Admin Menu';
        $arrEvents[0]['event_id'] = '';
        return $arrEvents;
    }
    $ci = & get_instance();
//    $ci->db->select('event.id as event_id,event.name as name');
//    if ($type == 'O') {
////        $ci->db->join('organizer', 'organizer.id = event.organizer_id');
////        $ci->db->where('organizer.user_id', $user_id);
//    } elseif($type == 'E') {
//        $ci->db->join('exhibitor', 'exhibitor.event_id = event.id');
//        $ci->db->where('exhibitor.user_id', $user_id);
//    }
//    $result = $ci->db->get('event');
//    
//    return $result->result_array();;

    $ci->load->model('event_model');
    return $ci->event_model->getOrganizerEvent($user_id, $type);
}

function generatePassword($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
    return substr(str_shuffle($chars), 0, $length);
}

/**
 * @function		GetAllCommon
 *
 * Short desc
 *
 * For fetching data from table and returns an array.
 *
 * @access          public
 * @param           string-$tableName , string-$strData (Option Parameter)
 * @return          array
 * @author          Rima mehta 
 * @since           Version 1.0
 * */
if (!function_exists('GetAllCommon')) {

    function GetAllCommon($tableName, $strData = '', $orderByField = '', $orderBySort = '') {
        $CI = & get_instance();

        if ($strData != '')
            $CI->db->select($strData);

        if ($orderByField != '')
            if ($orderBySort == '')
                $CI->db->order_by($orderByField, "ASC");
            else
                $CI->db->order_by($orderByField, $orderBySort);

        $query = $CI->db->get($tableName);
        //echo $CI->db->last_query();

        return $query->result_array();
    }

}



/**
 * @function		GetAllCommonWithWhere
 *
 * Short desc
 *
 * For fetching data from table with where condition and returns an array.
 *
 * @access	public
 * @param	string-$tableName , string-$where string-$strData (Option Parameter)
 * @return	array
 * @author	Rima mehta 
 * @since	Version 1.0
 * */
if (!function_exists('GetAllCommonWithWhere')) {

    function GetAllCommonWithWhere($tableName, $where, $strData = '', $orderByField = '', $orderBySort = '', $groupByFields = '', $distinct = '') {
        $CI = & get_instance();

        $CI->db->where($where);

        if ($distinct != '')
            $CI->db->distinct($distinct);

        if ($strData != '')
            $CI->db->select($strData);

        if ($groupByFields != '')
            $CI->db->group_by($groupByFields);

        if ($orderBySort == '')
            $orderBySort = 'ASC';

        if ($orderByField != '') {
            if (strpos($orderByField, ',') === false) {
                if (is_numeric($orderByField))
                    $CI->db->order_by($orderByField, $orderBySort);
                else
                    $CI->db->order_by("UPPER(" . $orderByField . ")", $orderBySort);
            }
            else {
                // when it comes here, it meas $orderByField has comma seperated fields
                $CI->db->order_by($orderByField, $orderBySort);
            }
        }

        $query = $CI->db->get($tableName);
        //echo $CI->db->last_query();die;
        //return $query->result (); // This will return object
        return $query->result_array();
    }

}


/**
 * GetKeyValueArrayCommon
 *
 * This is used to get array in Key value Form
 *
 * @author   Rima Mehta
 * @access   public
 * @param    
 * @return   array
 */
if (!function_exists('GetKeyValueArrayCommon')) {

    function GetKeyValueArrayCommon($arrData, $keyFieldName, $valueFieldname, $firstBlank = '') {

        $data = array();

        if ($firstBlank != '')
            $data[''] = "--- $firstBlank ---";

        if ($arrData) {
            for ($i = 0; $i < count($arrData); $i++)
                $data[trim($arrData[$i][$keyFieldName])] = trim($arrData[$i][$valueFieldname]);
        }

        return $data;
    }

}

function removeBlank($val) {
    return ($val || is_numeric($val));
}

function check_blank_values($val) {
    $val = trim($val);
    $allowed_vals = array("0"); // Add here your valid values
    return in_array($val, $allowed_vals, true) ? true : ($val ? true : false);
}

function getProfileStatus($id = NULL) {
    if ($id == NULL)
        return 'Looks Average';
    $ci = & get_instance();
    $ci->load->model('exhibitor_model');
    $objExhibitor = $ci->exhibitor_model->getAll($id, TRUE);
    $arrExhibitor = array();
    $arrExhibitor = (array) $objExhibitor;
    unset($arrExhibitor['exhibitor_id']);
    unset($arrExhibitor['id']);
    unset($arrExhibitor['is_featured']);
    unset($arrExhibitor['mail_sent']);
    unset($arrExhibitor['status']);
    unset($arrExhibitor['modified_by']);
    unset($arrExhibitor['modified_date']);
    unset($arrExhibitor['created_by']);
    unset($arrExhibitor['created_date']);
    unset($arrExhibitor['user_id']);
    unset($arrExhibitor['event_id']);
    unset($arrExhibitor['pvt_org_id']);
    unset($arrExhibitor['contact_id']);
    unset($arrExhibitor['location']);
    unset($arrExhibitor['latitude']);
    unset($arrExhibitor['longitude']);
    $arrProfile = array_filter($arrExhibitor, 'check_blank_values');

    $percentage = calulateProfile($arrExhibitor, $arrProfile);
//    exit;

    switch ($percentage) {
        case $percentage < 33 :
            $message = '<div class="infosummary">
						<ul>
							<li>
								<div class="datainfo">
									<span class="text-muted">Profile Completion</span>
									<h4>' . $percentage . '%</h4>
								</div>
							</li>
						</ul>
						<div class="progress progress-sm">
							<div style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
						</div>
						</div>';
            break;
        case $percentage <= 75 :
            $message = '<div class="infosummary">
						<ul>
							<li>
								<div class="datainfo">
									<span class="text-muted">Profile Completion</span>
									<h4>' . $percentage . '%</h4>
								</div>
							</li>
						</ul>
						<div class="progress progress-sm">
							<div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
						</div>
						</div>';
            break;
        case $percentage <= 100:
            $message = '<div class="infosummary">
						<ul>
							<li>
								<div class="datainfo">
									<span class="text-muted">Profile Completion</span>
									<h4>' . $percentage . '%</h4>
								</div>
							</li>
						</ul>
						<div class="progress progress-sm">
							<div style="width:100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"></div>
						</div>
						</div>';
            break;
    }
    return $message;
}

function calulateProfile($total, $filled) {
    $dn = count($total);
    $nu = count($filled);
    $per = floor(($nu / $dn) * 100);
    return $per;
}

function getTypeUser() {
    $ci = & get_instance();
    $type = $ci->session->userdata('type_of_user');
    return $type;
}

function display($var, $exit = FALSE) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    if ($exit)
        exit;
}

function front_image($type, $image) {
    switch ($type) {
        case 'attendee' :
            $upload_folder = 'attendee/' . $image;
            $avatar = 'attendee.png';
            break;
        case 'exhibitor' :
            $upload_folder = 'exhibitor/' . $image;
            $avatar = 'exhibitor.png';
            break;
        case 'logo' :
            $upload_folder = $image;
            $avatar = 'event_logo.png';
            break;
        case 'organizer' :
            $upload_folder = $image;
            $avatar = 'organizer.png';
            break;
        case 'speaker' :
            $upload_folder = 'speaker/' . $image;
            $avatar = 'speaker.png';
            break;
    }

    if ($image) {
        if (file_exists(UPLOADS . $upload_folder))
            $src_image = $upload_folder;
        else
            $src_image = 'avatar/' . $avatar;
    } else
        $src_image = 'avatar/' . $avatar;

    return $src_image;
}

function getNotification() {
    $ci = $ci = & get_instance();
    $type = $ci->session->userdata('type_of_user');
    $id = $ci->session->userdata('id');
    $ci->load->model('notification_model');
    $notification = $ci->notification_model->getNotification($type, $id);
    return $notification;
}

function getProfilePic($type = NULL, $id = NULL) {
    if (is_null($type) || is_null($id)) {
        return base_url('public/admin/images/user.png');
    }
}

function getAttendee_dropdown() {
    $ci = $ci = & get_instance();
    $ci->load->model('attendee_model');
    return $ci->attendee_model->getDropdownValues(NULL, FALSE);
}

function sendMail($to, $subject, $message, $htmlMessage = 1, $from_email = 'admin@procialize.net', $from_name = 'Procialize Admin') {
//    die('inside mail');
    if ($htmlMessage == 1)
        $htmlMessage = $message;

    try {
        $mandrill = new Mandrill(MANDRILL_API_KEY);
        $message = array(
            'html' => $htmlMessage,
            'text' => $message,
            'subject' => $subject,
            'from_email' => $from_email,
            'from_name' => $from_name,
            'to' => array(
                array(
                    'email' => $to,
                    'name' => 'Recipient Name',
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'message.reply@example.com'),
            'important' => false,
            'track_opens' => null,
            'track_clicks' => null,
            'auto_text' => null,
            'auto_html' => null,
            'inline_css' => null,
            'url_strip_qs' => null,
            'preserve_recipients' => null,
            'view_content_link' => null,
//            'bcc_address' => 'message.bcc_address@example.com',
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
//            'merge' => true,
//            'global_merge_vars' => array(
//                array(
//                    'name' => 'merge1',
//                    'content' => 'merge1 content'
//                )
//            ),
//            'merge_vars' => array(
//                array(
//                    'rcpt' => 'recipient.email@example.com',
//                    'vars' => array(
//                        array(
//                            'name' => 'merge2',
//                            'content' => 'merge2 content'
//                        )
//                    )
//                )
//            ),
            'tags' => array('password-resets'),
//            'subaccount' => 'customer-123',
//            'google_analytics_domains' => array('example.com'),
//            'google_analytics_campaign' => 'message.from_email@example.com',
//            'metadata' => array('website' => 'www.example.com'),
//            'recipient_metadata' => array(
//                array(
//                    'rcpt' => 'recipient.email@example.com',
//                    'values' => array('user_id' => 123456)
//                )
//            ),
//            'attachments' => array(
//                array(
//                    'type' => 'text/plain',
//                    'name' => 'myfile.txt',
//                    'content' => 'ZXhhbXBsZSBmaWxl'
//                )
//            ),
//            'images' => array(
//                array(
//                    'type' => 'image/png',
//                    'name' => 'IMAGECID',
//                    'content' => 'ZXhhbXBsZSBmaWxl'
//                )
//            )
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = '';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
//        print_r($result);
        return true;
    } catch (Mandrill_Error $e) {
        // Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
        return false;
    }
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getClientNotification() {
    $CI = & get_instance();
    $id = $CI->session->userdata('client_attendee_id');
    $CI->load->model('client/client_notification_model');
    $notification = $CI->client_notification_model->notificationCount($id);
    return $notification;
}

function getSocialMessages() {
    $CI = & get_instance();
    $event_id = $CI->session->userdata('client_event_id');
    if (!$event_id)
        return false;

    $attendee_id = $CI->session->userdata('client_attendee_id');
    $CI->load->model('client/client_notification_model');
    $CI->client_notification_model->activity_flag = '';
    $notification = $CI->client_notification_model->getSocialMessage($attendee_id, $event_id);
    return $notification;
}

function socialNotification() {
    $CI = & get_instance();
    $event_id = $CI->session->userdata('client_event_id');
    $attendee_id = $CI->session->userdata('client_attendee_id');
    if (!$attendee_id && $event_id)
        return FALSE;

    $CI->load->model('client/client_notification_model');
    $notification = $CI->client_notification_model->socialNotificationCount($attendee_id, $event_id);
    return $notification;
}

function show_query() {
    $CI = & get_instance();
    echo '<pre>';
    echo $CI->db->last_query();
    echo '</pre>';
}

function industry_functionality($industry, $functionality, $separator = ',') {
    if ($industry || $functionality) {
        $temp_industry = explode(',', $industry);
        $temp_func = explode(',', $functionality);
        //display($temp_industry);
//        /display($temp_func);
        $industry = '';
        $functionality = '';
        if (@$temp_industry[0] && @$temp_industry[0] != '-') {
            $separator = ',';
            $industry = @$temp_industry[0];
        } else
            $separator = '';
        if (@$temp_func[0] && @$temp_func[0] != '-') {
            $separator = ',';
            $functionality = $temp_func[0];
        } else
            $separator = '';



        $string = $industry . $separator . ' ' . $functionality;

        return $string;
    }
}

function city_country($city, $country, $separator = ',') {
    if ($city || $country) {
        if (!$city)
            $separator = '';
        elseif (!$country)
            $separator = '';

        $string = $city . $separator . ' ' . $country;

        return $string;
    }
}

function designation_company($designation, $company, $separator = '-') {
    if ($designation || $company) {
        if (!$designation || !$company)
            $separator = '';


        $string = $designation . ' ' . $separator . ' ' . $company;

        return $string;
    }
}

function bracket_attendee_attribute($param1, $param2, $separator = ',') {
    if (!$param1 || !$param2)
        $separator = '';

    $string = '';
    if ($param1 && $param2) {
        $string = '(' . $param1 . ' ' . $separator . ' ' . $param2 . ')';
    } elseif ($param1 && !$param2) {
        $string = '(' . $param1 . ')';
    } elseif (!$param1 && $param2) {
        $string = '(' . $param2 . ')';
    }
    return $string;
}

function saved_icon($page, $subject_id) {
    $CI = & get_instance();
    $attendee_id = $CI->session->userdata('client_attendee_id');
    $CI->load->model('client/client_notification_model');
    $page_array = array(
        'attendee-detail',
        'speaker-detail',
        'exhibitor-detail',
    );
    $icon_html = '';
    if (in_array($page, $page_array) && is_numeric($subject_id)) {
        $check_for_saved = $CI->client_notification_model->checkSavedShared($subject_id, $attendee_id, $type = 'Sav');
        //display($check_for_saved);
        if ($check_for_saved) {
            $icon_html = '<li>
                                    <div class="btn-group">
                                      <button class="btn btn-default dropdown-toggle tp-icon active socialSave" value="TRUE" id="' . $subject_id . '">
                                        <i class="glyphicon glyphicon-floppy-disk"></i>
                                      </button>
                                    </div>
                                <li>';
        } else {
            $icon_html = '<li>
                                    <div class="btn-group">
                                      <button class="btn btn-default dropdown-toggle tp-icon socialSave" value="" id="' . $subject_id . '">
                                        <i class="glyphicon glyphicon-floppy-disk"></i>
                                      </button>
                                    </div>
                                <li>';
        }
    }
    return $icon_html;
}

function share_icon($page, $subject_id) {
    $CI = & get_instance();
    $icon_html = '';
    $attendee_id = $CI->session->userdata('client_attendee_id');
    $CI->load->model('client/client_notification_model');
    $page_array = array(
        'attendee-detail',
        'speaker-detail',
        'exhibitor-detail',
            //'event-detail',
    );
    if (in_array($page, $page_array) && is_numeric($subject_id)) {
        $icon_html = '<li>
            <div class="btn-group">
              <a href="#"  data-toggle="modal" data-target="#share">
		<button class="btn btn-default dropdown-toggle tp-icon" >
                <i class="fa fa-share-alt"></i>
              	</button>
		</a>
            </div>
          </li>';
    }
    return $icon_html;
}

function passcode_validatation() {
    $CI = & get_instance();
    $attendee_id = $CI->session->userdata('client_attendee_id');
    $event_id = $CI->session->userdata('client_event_id');
    $CI->load->model('client/client_event_model');
    if (!$attendee_id && !$event_id)
        return FALSE;

    $passcode = $CI->client_event_model->check_passcode($event_id, $attendee_id);
    if ($passcode)
        return TRUE;
    else
        return FALSE;
}

function getAttendeeType($attendee_id) {
    $CI = & get_instance();
    $CI->load->model('client/client_event_model');
    $attendee_type = $CI->client_event_model->getAttendeeType($attendee_id);

    return $attendee_type;
}

function show_normal_ad() {
    $CI = & get_instance();
    $event_id = $CI->session->userdata('client_event_id');
    if ($event_id) {
        $CI->load->model('client/client_notification_model');
        $ad = $CI->client_notification_model->getNormalAd($event_id);
        //show_query();
        //display($ad);
        return $ad;
    } else
        return FALSE;
}

function check_access_token($api_access_token, $check_null = FALSE) {
    if (!$api_access_token) {
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Token!';
        header('Content-Type: application/json');
        echo json_encode($json_array);
        exit;
    }
    $CI = & get_instance();
    $CI->load->model('API/client_event_api_model');
    $user_data = $CI->client_event_api_model->getUser($api_access_token);

    if ($user_data) {
        //display($user_data);
        return $user_data;
    } else {
        $json_array['error'] = 'error';
        $json_array['msg'] = 'Invalid Token!';
        header('Content-Type: application/json');
        echo json_encode($json_array);
        exit;
        return FALSE;
    }
}

function json_output($json_array) {
    header('Content-Type: application/json');
    echo json_encode($json_array);
    exit;
}

function getTwitterHashTag() {
    $CI = & get_instance();
    $event_id = $CI->session->userdata('client_event_id');
    $CI->load->model('client/client_event_model');

    if (!$event_id)
        return FALSE;


    $twitter_hashtag = $CI->client_event_model->getHashTag($event_id);

    return $twitter_hashtag;
}

function push_analytics($type, $subject_id, $subject_type) {
    $CI = & get_instance();
    $object_id = $attendee_id = $CI->session->userdata('client_attendee_id');
    $object_type = $attendee_type = $CI->session->userdata('client_user_type');
    $event_id = $CI->session->userdata('client_event_id');
    $CI->load->model('client/client_event_model');

    $CI->client_event_model->push_analytics($type, $object_id, $object_type, $subject_id, $subject_type, $event_id);
}

function createDateRangeArray($start, $end) {
    $range = array();
    if (is_string($start) === true)
        $start = strtotime($start);
    if (is_string($end) === true)
        $end = strtotime($end);
    if ($start > $end)
        return createDateRangeArray($end, $start);
    do {
        $range[] = date('Y-m-d', $start);
        $start = strtotime("+ 1 day", $start);
    } while ($start <= $end);
    return $range;
}

function update_rightside_notification() {
    $CI = & get_instance();
    $event_id = $CI->session->userdata('client_event_id');
    $attendee_id = $CI->session->userdata('client_attendee_id');
    if (!$attendee_id && $event_id)
        return FALSE;

    $CI->load->model('client/client_notification_model');
    $notification = $CI->client_notification_model->insertSocialNotificationCount($attendee_id, $event_id);
}

function check_DND($attendee_id) {
    $CI = & get_instance();
    if (!$attendee_id)
        return FALSE;

    $CI->load->model('client/client_notification_model');
    $get_dnd = $CI->client_notification_model->getDND($attendee_id);
    //show_query();
    //display($get_dnd);
    return $get_dnd;
}

function getSetting() {
    $CI = & get_instance();
    $CI->load->model('setting_model');
    $setting_data = json_decode($CI->setting_model->get_setting());
    //display($setting_data);
    return $setting_data;
}

function getSession() {
    $CI = & get_instance();
    $event_id = $CI->session->userdata('client_event_id');
    $CI->load->model('client/client_event_model');

    $getSession = $CI->client_event_model->getSession(NULL, $event_id);
    return $getSession;
}

function get_email_template($email_template_name) {
    $CI = & get_instance();
    $CI->load->model('setting_model');
    $setting_data = json_decode($CI->setting_model->get_setting());
    $setting_data = (array) $setting_data;
    $CI->db->select('email_template.name,email_template.subject,email_template.body');
    $CI->db->where('email_template.status', 1);
    $CI->db->where('email_template.temp_name', $email_template_name);
    $result = $CI->db->get('email_template')->row();
    $result = (array) $result;
    $result['setting'] = $setting_data;
    return $result;
}
