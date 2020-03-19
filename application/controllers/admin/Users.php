<?php
class Users extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('User_Model','Country_Model','City_Model'));

		$this->page = $this->config->item("base_url_admin")."users";

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),10);

		if(!$this->session->userdata('fname') && 
			!$this->session->userdata('lname') &&
			!$this->session->userdata('userId') && 
			!$this->session->userdata('email') &&
			!$this->session->userdata('mobile') && 
			!$this->session->userdata('roleId') &&
			!$this->session->userdata('loggedin'))
		{
			header("Location:".$this->config->item("base_url_admin"));
		}
	
	}


	function index()
	{
		if(isset($this->permission['create']))
		{
			$data['create'] = "create";
		}
		else{ $data = ""; }

		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/users/table',$data,'admin');
	}

	function fetch()
	{

		$fetch_data = $this->User_Model->fetch_dataUser();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->userCode;
			$sub_array[] = $row->firstName;
			$sub_array[] = $row->lastName;
			$sub_array[] = $row->userEmail;
			$sub_array[] = $row->userMobile;
			$sub_array[] = $row->roleName;

			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';								
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 				
			}

			if(isset($this->permission))
			{
				if(isset($this->permission['view']))
				{
					$view = '';
				}
				else
				{
					$view = '';
				}

				if(isset($this->permission['status']))
				{
					if($row->active_status == 1)
					{
						$status = '<a href ="'.base_url('admin/users').'/status/activate/'.$row->userId.'" type="submit" name="delete" id="'.$row->userId.'" class="update" ><i class="fa fa-check-square"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/users').'/status/deactivate/'.$row->userId.'" type="submit" name="delete" id="'.$row->userId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a href ="'.base_url('admin/users').'/edit/'.$row->userId.'" type="submit" name="edit" id="'.$row->userId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/users').'/delete/'.$row->userId.'" type="submit" name="edit" id="'.$row->userId.'" class="edit" ><i class="fa fa-trash"></i></a>';
				}
				else
				{
					$delete = '';
				}

				$sub_array[] = '<div align="center">'.$status.'&nbsp&nbsp'.$update.'&nbsp&nbsp'.$delete.'</div>';
			}
			else
			{
				$sub_array[] = '<div align="center">NO ACTIONS ALLOWED</div>';
			}
  
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->User_Model->get_all_dataUser(),  
			"recordsFiltered"     	=>     $this->User_Model->get_filtered_dataUser(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['roles'] = $this->User_Model->getRoles();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/users/form',$data,'admin');
	}

	function save()
	{
		$this->User_Model->saveUser();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->User_Model->statusUser();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['roles'] = $this->User_Model->getRoles();
		$data['user'] = $this->User_Model->getUser();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/users/form',$data,'admin');
	}

	function update()
	{
		$this->User_Model->updateUser();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->User_Model->deleteUser();
		header("Location:".$this->page);
	}


	function fetchState()
	{
		$states = $this->State_Model->getSpecific();

		if($states)
		{
			echo '<option value="">Select State</option>';
			foreach($states as $row)
			{
				echo '<option value="'.$row->stateId.'">'.$row->stateName.'</option>';
			}
		}
		else
		{
			echo '<option value="">No States Entered</option>';
		}
	}


} ?>