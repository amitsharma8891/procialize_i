<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */





include_once APPPATH . 'helpers/comman_helper.php';

$arrMenus = array();
$arrMenus = menuArray();
foreach ($arrMenus as $menu) {
    if ($menu == 'Event Profile')
        $menu = 'event';
    if ($menu == 'Dashboard')
        $menu = 'index';

    $route["manage/" . strtolower($menu) . "/(:num)"] = "manage/" . strtolower($menu) . "/index/$1";
    $route['manage/event-map'] = 'manage/image_maping';
    $route['manage/event-map/(:any)'] = 'manage/image_maping';
}


$route['default_controller'] = "client/home/welcome";
$route['404_override'] = '';
//client routing
//$route['login']                                                                 = 'client/login';
$route['welcome'] = 'client/home/welcome';


$route['search'] = 'client/home/home_view';
$route['login'] = 'client/login/index';
$route['events'] = 'client/event/event_list';
$route['events/agenda/session-detail/(:any)'] = 'client/event/session_detail';
$route['events/json'] = 'client/event/event_list/json';
//$route['events/(:any)']                                                                = 'client/event/event_list/$1';
$route['events/event-detail/(:any)'] = 'client/event/event_detail/$1';
//$route['events/event-detail/(:any)']                                            = 'client/event/event_detail/$1/$1';
$route['events/attendee'] = 'client/event/attendee_list';
$route['events/attendee/(:any)'] = 'client/event/attendee_list/$1';
$route['events/attendee-detail/(:any)'] = 'client/event/attendee_detail';
$route['events/exhibitor'] = 'client/event/exhibitor_list';
$route['events/exhibitor/(:any)'] = 'client/event/exhibitor_list/$1';
$route['events/exhibitor-detail/(:any)'] = 'client/event/exhibitor_detail/';
$route['events/speaker'] = 'client/event/speaker_list';
$route['events/speaker/(:any)'] = 'client/event/speaker_list/json';
$route['events/speaker-detail/(:any)'] = 'client/event/speaker_detail/$1';
$route['events/agenda/(:any)'] = 'client/event/agenda/json';
$route['events/agenda'] = 'client/event/agenda';
$route['notification'] = 'client/user_notification/notification_view';
$route['notification/details/(:any)'] = 'client/user_notification/notification_detail/$1';

$route['profile-view'] = 'client/user/profile_view';
$route['user/register'] = 'client/user/profile_view';
$route['user/login-view'] = 'client/user/login_view';
$route['events/set-meeting/(:any)'] = 'client/event/setup_meeting';
$route['user/saved/(:any)'] = 'client/user/saved_profile/$1';


$route['user/change-password/(:any)'] = 'client/user/change_password_view/$1';






//$route['events/(:any)']                                                         = 'client/event/event_list/event_list/$1';




/* End of file routes.php */
/* Location: ./application/config/routes.php */