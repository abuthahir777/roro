<?php
class Users extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('User_Model','Country_Model','City_Model'));

		$this->page = $this->config->item("base_url")."/admin/users";

		if($this->session->userdata('userdata') == NULL)
		{
			header("Location:".$this->config->item("base_url_admin"));
		}
	
	}


	function index()
	{
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/users/table','','admin');
	}

	function fetch()
	{
		$permission = $this->permission->setRights($this->session->userdata('roleId'),10);

		$fetch_data = $this->User_Model->fetch_dataUser();  
		$data = array();  
		$i=1;

$permission['view'] = "View";
$permission['create'] = "Create";
$permission['update'] = "Update";
$permission['delete'] = "Delete";
$permission['status'] = "Status";

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

			if(isset($permission))
			{
				if(isset($permission['view']))
				{
					$view = '';
				}
				else
				{
					$view = '';
				}

				if(isset($permission['status']))
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

				if(isset($permission['update']))
				{
					$update = '<a href ="'.base_url('admin/users').'/edit/'.$row->userId.'" type="submit" name="edit" id="'.$row->userId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($permission['delete']))
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
				$sub_array[] = '<div align="center">NO ACTIONS</div>';
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
		$this->City_Model->delete();
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