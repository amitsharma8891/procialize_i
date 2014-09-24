<?php 
$config =& get_config();
//display($_SERVER);exit;
$user_role    = $_SERVER['REQUEST_URI'];
$temp         = explode('/',$user_role);
//display($temp);exit;
if($temp && @$temp[2] != 'manage')
echo file_get_contents(SITE_URL . 'client/error_controller/error_404'); 
else
    echo '<html><head><title>Admin Page Not Found</title></head><body><h1>404 Error!<br><a href='.SITE_URL.'manage/index>Click Here</a></h1></body></html>';