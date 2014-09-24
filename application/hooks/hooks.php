<?php

class hooks {

    private $ci;
    private $router;
    private $arr_action = array('index', 'add', 'edit', 'delete');
    public $session;

    function __construct() {
        $this->ci = & get_instance();
        $this->router = & load_class('Router', 'core');
        $this->session = $this->ci->session->all_userdata();
    }

    public function bootstrap() {
        $this->logged_in();
        $this->auth();
    }

    function logged_in() {
        $url = uri_string();
        $class_name = $this->router->fetch_class();
        $method_name = $this->router->fetch_method();
        if (preg_match("/^manage/", $url)) {
            if ($class_name != 'login') {
                if (!isset($this->session['user_id']))
                    redirect('manage/login');
            }
        }
    }

    function auth() {
        $url = uri_string();

        $type = $this->ci->session->userdata('type_of_user');
        $superadmin = $this->ci->session->userdata('is_superadmin');
        if ($superadmin)
            return;
        if (preg_match("/^manage/", $url)) {
            $arrMenus = generateMenu($type, $superadmin);
//            echo '<pre>';
//            echo $this->ci->uri->segment(1);
//            echo $this->ci->uri->segment(2);

            ;
        }
    }

}

?>
