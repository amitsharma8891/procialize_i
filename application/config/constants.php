<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



define('UPLOAD_ORGANIZER_LOGO', './uploads/organizer/logo/');
define('UPLOAD_ORGANIZER_LOGO_DISPLAY', 'uploads/organizer/logo/');

define('UPLOAD_SPONSOR_NORMAL', './uploads/sponsor/normal_ad/');
define('UPLOAD_SPONSOR_NORMAL_DISPLAY', 'uploads/sponsor/normal_ad/');

define('UPLOAD_SPONSOR_SPLASH', './uploads/sponsor/splash_ad/');
define('UPLOAD_SPONSOR_SPLASH_DISPLAY', 'uploads/sponsor/splash_ad/');

define('UPLOAD_EVENT_LOGO', './uploads/events/logo/');
define('UPLOAD_EVENT_LOGO_DISPLAY', 'uploads/events/logo/');

define('UPLOAD_EVENT_FLOORPLAN', './uploads/events/floorplan/');
define('UPLOAD_EVENT_FLOORPLAN_DISPLAY', 'uploads/events/floorplan/');

define('UPLOAD_EVENT_IMAGES', './uploads/events/images/');
define('UPLOAD_EVENT_IMAGES_DISPLAY', 'uploads/events/images/');


define('UPLOAD_EXHIBITOR_LOGO', './uploads/exhibitor/');
define('UPLOAD_EXHIBITOR_LOGO_DISPLAY', 'uploads/exhibitor/');

define('UPLOAD_SPONSOR_LOGO', './uploads/sponsor/');
define('UPLOAD_SPONSOR_LOGO_DISPLAY', 'uploads/sponsor/');

define('UPLOAD_SPEAKER_LOGO', './uploads/speaker/');
define('UPLOAD_SPEAKER_LOGO_DISPLAY', 'uploads/speaker/');

define('UPLOAD_ATTENDEE_PHOTO', './uploads/attendee/');
define('UPLOAD_ATTENDEE_PHOTO_DISPLAY', 'uploads/attendee/');

define('UPLOAD_SESSION_PHOTO', './uploads/session/');
define('UPLOAD_SESSION_PHOTO_DISPLAY', 'uploads/session/');

define('UPLOAD_EXHIBITOR_BROCHURE', './uploads/exhibitor/brochure/');
define('UPLOAD_EXHIBITOR_BROCHURE_DISPLAY', 'uploads/exhibitor/brochure/');

define('UPLOAD_EXHIBITOR_FLOORPLAN', './uploads/exhibitor/floorplan/');
define('UPLOAD_EXHIBITOR_FLOORPLAN_DISPLAY', 'uploads/exhibitor/floorplan/');

$root = trim(BASEPATH, '/system');
define('IMAGE_BASEPATH', '/'.$root);
define('IMAGE_BASEPATH1',  '/httpdocs/beta/');



#######################################################client constants#############################################################################

define('SITE_URL',                                                               'http://192.168.2.148/procialize/');
define('CLIENT',                                                                'client/');
define('IMAGES',                                                                'images/');
define('SCRIPTS',                                                               'scripts/');
define('CSS',                                                                   'css/');
define('INCLUDES',                                                              'includes/');
define('UPLOADS',                                                               $_SERVER['DOCUMENT_ROOT'].'/procialize/uploads/');

//client ui
define('CLIENT_CSS',                                                            SITE_URL.'public/'.CLIENT.'css/');
define('CLIENT_IMAGES',                                                         SITE_URL.'public/'.CLIENT.'images/');
define('CLIENT_SCRIPTS',                                                        SITE_URL.'public/'.CLIENT.'js/');
define('CLIENT_PLUGINS',                                                        SITE_URL.'public/'.CLIENT.'plugins/');


//client view
define('CLIENT_VIEWS_FOLDER', 							CLIENT);
define('CLIENT_INCLUDES_FOLDER',                                                CLIENT.'includes/');
define('CLIENT_HEADER',                                                         CLIENT_INCLUDES_FOLDER.'header.php');
define('CLIENT_FOOTER',                                                         CLIENT_INCLUDES_FOLDER.'footer.php');
define('CLIENT_LEFT_PANEL',                                                     CLIENT_INCLUDES_FOLDER.'leftpanel.php');
define('CLIENT_RIGHT_PANEL',                                                    CLIENT_INCLUDES_FOLDER.'rightpanel.php');
define('EVENT_TOP_NAVIGATION',                                                  CLIENT_INCLUDES_FOLDER.'event_top_navigation.php');

define('CLIENT_HOME_VIEWS_FOLDER', 						CLIENT_VIEWS_FOLDER.'home/');
define('CLIENT_HOME_VIEW',      						CLIENT_HOME_VIEWS_FOLDER.'client_home_view.php');

define('CLIENT_LOGIN_VIEWS_FOLDER', 						CLIENT_VIEWS_FOLDER.'login/');
define('CLIENT_LOGIN_VIEW',      						CLIENT_LOGIN_VIEWS_FOLDER.'client_login_view.php');

define('CLIENT_EVENT_VIEWS_FOLDER', 						CLIENT_VIEWS_FOLDER.'event/');
define('CLIENT_EVENT_LIST_VIEW',      						CLIENT_EVENT_VIEWS_FOLDER.'client_event_list_view.php');
define('CLIENT_EVENT_DETAIL_VIEW',                                              CLIENT_EVENT_VIEWS_FOLDER.'client_event_detail_view.php');

define('CLIENT_AGENDA_VIEWS_FOLDER', 						CLIENT_VIEWS_FOLDER.'agenda/');
define('CLIENT_EVENT_SETUP_MEETING_VIEW',       				CLIENT_AGENDA_VIEWS_FOLDER.'client_event_setup_meeting_view.php');
define('CLIENT_EVENT_MY_CALENDER_VIEW',                                         CLIENT_AGENDA_VIEWS_FOLDER.'client_mycalender_view.php');
define('CLIENT_EVENT_TARGET_CALENDER_VIEW',       				CLIENT_AGENDA_VIEWS_FOLDER.'client_tareget_calender_view.php');
//define('CLIENT_EVENT_DETAIL_VIEW',                                              CLIENT_EVENT_VIEWS_FOLDER.'client_event_detail_view.php');

define('CLIENT_ATTENDEE_VIEWS_FOLDER', 						CLIENT_VIEWS_FOLDER.'attendee/');
define('CLIENT_EVENT_ATTENDEE_LIST_VIEW',                                       CLIENT_ATTENDEE_VIEWS_FOLDER.'client_event_attendee_list_view.php');
define('CLIENT_EVENT_ATTENDEE_DETAIL_VIEW',                                     CLIENT_ATTENDEE_VIEWS_FOLDER.'client_event_attendee_detail_view.php');

define('CLIENT_EXHIBITOR_VIEWS_FOLDER',                                         CLIENT_VIEWS_FOLDER.'exhibitor/');
define('CLIENT_EVENT_EXHIBITOR_LIST_VIEW',                                      CLIENT_EXHIBITOR_VIEWS_FOLDER.'client_event_exhibitor_list_view.php');
define('CLIENT_EVENT_EXHIBITOR_DETAIL_VIEW',                                    CLIENT_EXHIBITOR_VIEWS_FOLDER.'client_event_exhibitor_detail_view.php');

define('CLIENT_SPEAKER_VIEWS_FOLDER',                                           CLIENT_VIEWS_FOLDER.'speaker/');
define('CLIENT_EVENT_SPEAKER_LIST_VIEW',                                        CLIENT_SPEAKER_VIEWS_FOLDER.'client_event_speaker_list_view.php');
define('CLIENT_EVENT_SPEAKER_DETAIL_VIEW',                                      CLIENT_SPEAKER_VIEWS_FOLDER.'client_event_speaker_detail_view.php');

define('CLIENT_EVENT_SESSION_DETAIL_VIEW',                                      CLIENT_EVENT_VIEWS_FOLDER.'client_event_session_detail_view.php');

define('CLIENT_NOTIFICATION_FOLDER', 						CLIENT_VIEWS_FOLDER.'notification/');
define('CLIENT_NOTIFICATION_VIEW',                                              CLIENT_NOTIFICATION_FOLDER.'client_notification_view.php');
define('CLIENT_NOTIFICATION_DETAIL_VIEW',                                       CLIENT_NOTIFICATION_FOLDER.'client_notification_detail_view.php');

define('CLIENT_USER_FOLDER',                            			CLIENT_VIEWS_FOLDER.'user/');
define('CLIENT_USER_PROFILE_VIEW',                                              CLIENT_USER_FOLDER.'client_user_profile_view.php');
define('CLIENT_USER_SAVED_PROFILE_VIEW',                                        CLIENT_USER_FOLDER.'client_user_saved_view.php');
define('CLIENT_USER_RESET_PASSWORD_VIEW',                                        CLIENT_USER_FOLDER.'client_reset_password_view.php');

define('CLIENT_ERROR_FOLDER',                            			CLIENT_VIEWS_FOLDER.'error/');
define('CLIENT_DATA_ERROR_VIEW',                                                CLIENT_ERROR_FOLDER.'client_data_error_view.php');
define('CLIENT_404_ERROR_VIEW',                                                 CLIENT_ERROR_FOLDER.'client_404_error_view.php');

define('CLIENT_WELCOME_FOLDER',                            			CLIENT_VIEWS_FOLDER.'welcome/');
define('CLIENT_WELCOME_VIEW',                                                   CLIENT_WELCOME_FOLDER.'client_welcome_view.php');

define('ADMIN_EMAIL_ADDRESS',                                                   'amit.sharma@infiniteit.biz');

define('PAGE_LIMIT',                                                            25);


define('EVENT_CONTROLLER_PATH',                                                 'events/');
define('DEFAULT_TWITTER_HASHTAG',                                               'procialize');
define('FB_APP_ID',                                                             '664018516966781');
//define('LI_APP_ID',                                                             '75jkhafjcxrmm6');
define('LI_APP_ID',                                                             '75x3t34knb3p7k');
//define('FB_APP_ID',                                                             '648680631894327');
define("GOOGLE_API_KEY", "AIzaSyCesr3wzsY155Be03NQn32UdHG4mS3I3MI");

//define('MANDRILL_API_KEY','nOBJIc6VJN27PcHl1o8o0w');
define('MANDRILL_API_KEY','5xnj4URF5MtrOkEC9uRDqg');
define('SURVEY_CONTENT_PRE','<a href=\'');
define('SURVEY_CONTENT_POST','\'>Click Here</a>  to attend survey');
define('FEEDBACK_CONTENT','notification/details/F/');

define('APPLE_APP_STORE_IMAGE', 'apple_store.png');
define('GOOGLE_PLAY_STORE_IMAGE', 'play_store.png');
/* End of file constants.php */
/* Location: ./application/config/constants.php */
