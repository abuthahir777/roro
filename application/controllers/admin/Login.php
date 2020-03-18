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
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run())
		{
			$email=$this->input->post('email');
			$password=$this->input->post('password');

			$data = $this->User_Model->validate($email,$password);

			echo '<pre>'; print_r($data); echo '</pre>';

			if(isset($data))
			{
				$userdata = array('fname'=>$data->firstName,'lname'=>$data->lastName,'userId'=>$data->userCode,'email'=>$data->userEmail,'mobile'=>$data->userMobile,'roleId'=>$data->roleId,'loggedin'=> TRUE);
				$this->session->set_userdata($userdata);

				header("Location:". $this->page."/country");
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


	public function logout()
	{
			$this->session->unset_userdata('userdata');
			header("Location:".$this->page);
	}


} ?>