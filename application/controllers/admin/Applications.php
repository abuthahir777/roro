<?php
class Applications extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('',''));

		$this->load->library(array('Layouts'));

	}


	function index()
	{
		header("Access-Control-Allow-Origin: *");
		$this->layouts->title('Applications');
		$this->layouts->view('pages/admin/first','','admin_t');
	}


}
?>