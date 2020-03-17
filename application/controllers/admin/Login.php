<?php
class Login extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('User_Model'));

		$this->load->library(array('Layouts'));

		$this->page = $this->config->item("base_url")."/admin";
	
	}


	function index()
	{
		$this->load->view('pages/admin/login');
	}


	public function validate()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run())
		{
			$username=$this->input->post('username');
			$password=$this->input->post('password');

			echo $data = $this->User_Model->validate($username,$password);
			exit();

			if(md5($password)==$data->password)
			{
				$userdata = array('email'=>$data->username,'user'=>'Admin','loggedin'=> TRUE);
				$this->session->set_userdata('userdata',$userdata);

				header("Location:". $this->config->item("base_url")."admin/country");
			}
			else
			{
				$this->session->set_flashdata('error','Invalid name or password');
				header("Location:".$this->page);
			}
	
		}
		else
		{
			header("Location:".$this->page);
		}

	}


	// function register()
	// {
	// 	$this->load->view('pages/admin/register');
	// }

	// function register_form()
	// {
	// 	$this->User_Model->save();
	// }


	public function logout()
	{
			$this->session->unset_userdata('userdata');
			redirect('admin');
	}


} ?>