<?php 

class Index extends CI_Controller {

    /**
    * Index Class
    *
    * @package	Procialize 
    * @subpackage	Index controller
    * @author		Aatish Gore
    * @copyright	Copyright (c) 2014 - 2015 
    * @since		Version 1.0
    */
    function __construct()
    {
        parent::__construct();
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
	public function index()
	{
                $arrData['thisPage'] = 'Default Organizer';
		$this->load->view('admin/default',$arrData);
	}
}

/* End of file index.php */
/* Location: ./application/controllers/admin/welcome.php */