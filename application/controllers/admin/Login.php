<?php
class Login extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('User_Model'));

		$this->page = $this->config->item("base_url_admin");
	
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

			if(isset($data))
			{
				$userdata = array('fname'=>$data->firstName,'lname'=>$data->lastName,'userId'=>$data->userCode,'email'=>$data->userEmail,'mobile'=>$data->userMobile,'roleId'=>$data->roleId,'loggedin'=> TRUE);
				$this->session->set_userdata($userdata);

				$tables = $this->User_Model->getViewPermissions($data->roleId);

				foreach($tables as $table)
				{
					$this->session->set_userdata($table->tableName,$table->tableName);
				}

				header("Location:". $this->page."/dashboard");
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
			$tables = $this->User_Model->getallTable();

			foreach($tables as $table)
			{
				$this->session->unset_userdata($table->tableName);
			}

			$this->session->unset_userdata('fname');
			$this->session->unset_userdata('lname');
			$this->session->unset_userdata('userId');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('mobile');
			$this->session->unset_userdata('roleId');
			$this->session->unset_userdata('loggedin');

			header("Location:".$this->page);
	}


} ?>