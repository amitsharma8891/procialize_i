<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Manage Class
 *
 * @package	Jito 
 * @subpackage	Custom Pagination controller
 * @author	Shailendra Gupta
 * @copyright	Copyright (c) 2013 - 2014 
 * @since		Version 1.0
 */

class Manage_pagination extends CI_Controller {
	
	//offset of the page
	public $offsetPage;
	public $arr_data;
	public $offset;
	public $url;
	public $strpagination;
	public $limit;
        public $per_page = 2;//PER_PAGE;

	/**
	* __construct
	*
	* Calls parent constructor
	* @author	Aatish Gore
	* @access	public
	* @param  null
	* @return	void
	*/
	function __construct()
	{
		parent::__construct();	
		 $this->event_id = (get_cookie('event_id') != '') ? get_cookie('event_id') : '';
	}

	/**
	* index
	*
	* This displays Manage
	* 
	* @author	Aatish Gore
	* @access	public
	* @param	null
	* @return	void
	*/
	public function request()
	{
		
		$arrData['middle'] = 'request'; 
		$this->load->view('frontend/template',$arrData);
	}
	
	/**
	* pagination
	*
	* This manages pagination settings
	* 
	* @author	Ruchira Shree 
	* @access	public
	* @param	null
	* @return	void
	*/
	public function pagination()
	{
		$per_page = $this->per_page;
		$no_of_links = 5;
		$arrData['perpage'] = $per_page;
		$arrData['no_of_links'] = $no_of_links;
		return $arrData;
	}

	public function get_pagination_settings()
	{
            $resPagination = $this->pagination();
            $config = array();
            
            $config['uri_segment']                                              = 3;
            $config['first_link']                                               = 'First';
            $config['next_link']                                                = 'Next';
            $config['prev_link']                                                = 'Prev';
            $config['last_link']                                                = 'Last';
            $config['use_page_numbers']                                         = TRUE;
            //$config['num_links'] = isset($resPagination['no_of_links'])?$resPagination['no_of_links']:5;
            $config['per_page'] = $this->per_page;//isset($resPagination['perpage'])?$resPagination['perpage']:2;
            return $config;
	}
	/**
	* pagination
	*
	* This manages pagination settings
	* 
	* @author	Aatish Gore
	* @access	public
	* @param	null
	* @return	void
	*/
	
	public function setup_pagination($perpage = NULL){
		
                $total_rows = sizeof($this->arr_data);
		
		$resPagination = $this->pagination();
		$config = array();
		$config = $this->get_pagination_settings();
		//load pagination library
		$this->load->library('pagination');
		//set pagination config vars
		$config['base_url'] = base_url().$this->url;
		$config['total_rows'] = $total_rows;
		$config['cur_page'] = $this->offset;
	
		$this->limit = $limit = isset($resPagination['perpage'])?$resPagination['perpage']:2;
		//initialize pagination with config
		$this->pagination->initialize($config);
		$this->strpagination = $this->pagination->create_links();
		//get records  based on current page
		$this->offsetPage = ($this->offset - 1) * $limit;
		
	}
	
	/**
	* get_serial_num
	*
	* This manages serial number
	* 
	* @author	Chhanda Rane, Harshada Kakade
	* @access	public
	* @param	null
	* @return	void
	*/
	
	public function get_serial_num($page_num){
		
		$sr_no = (($page_num * PER_PAGE) - PER_PAGE) + 1;
		return $sr_no;
		
	}
}

/* End of file manage.php */
/* Location: ./application/modules/manage/controllers/manage.php */
