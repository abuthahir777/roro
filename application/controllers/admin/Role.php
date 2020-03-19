<?php
class Role extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('User_Model'));

		$this->page = $this->config->item("base_url_admin")."role";

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),9);

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

		$this->layouts->title('Role Table');
		$this->layouts->view('pages/admin/role/table',$data,'admin');
	}

	function fetchRole()
	{
		$fetch_data = $this->User_Model->fetch_dataRole();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
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

				if(isset($this->permission['status']))
				{
					if($row->active_status == 1)
					{
						$status = '<a href ="'.base_url('admin/role').'/status/activate/'.$row->roleId.'" type="submit" name="delete" id="'.$row->roleId.'" class="update" ><i class="fa fa-check-square"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/role').'/status/deactivate/'.$row->roleId.'" type="submit" name="delete" id="'.$row->roleId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a href ="'.base_url('admin/role').'/edit/'.$row->roleId.'" type="submit" name="edit" id="'.$row->roleId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/role').'/delete/'.$row->roleId.'" type="submit" name="edit" id="'.$row->roleId.'" class="edit" ><i class="fa fa-trash"></i></a>';
				}
				else
				{
					$delete = '';
				}
			}


			$sub_array[] = '<div align="center">'.$status.'&nbsp&nbsp'.$update.'&nbsp&nbsp'.$delete.'</div>';   
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->User_Model->get_all_dataRole(),  
			"recordsFiltered"     	=>     $this->User_Model->get_filtered_dataRole(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['modules'] = $this->User_Model->getModule(NULL);

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/role/form',$data,'admin');
	}

	function save()
	{
		$rolename = $this->input->post('rolename');
		$this->User_Model->saveRole($rolename);
		$role = $this->User_Model->getRole();
		$modules = $this->input->post('module');
		
		foreach ($modules as $module)
		{
			$this->User_Model->saveRights($role->roleId,$module);
		}

		header("Location:".$this->page);
	}


	function status()
	{
		$this->User_Model->statusRole();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['rights'] = $this->User_Model->getRights();
		$data['modules'] = $this->User_Model->getModule(NULL);
		$data['role'] = $this->User_Model->getRolebyID();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/role/form',$data,'admin');
	}

	function update()
	{
		$roleId = $this->input->post('id');
		$this->User_Model->updateRole($roleId);
		$this->User_Model->updateRights($roleId);
		$module = $this->input->post('module');
		
		foreach($module as $row)
		{
			$this->User_Model->saveRights($roleId,$row);
		}

		header("Location:".$this->page);
	}

	function delete()
	{
		$this->User_Model->deleteRole();
		header("Location:".$this->page);
	}


	function check()
	{
		$table = 8;
		$permissio = $this->User_Model->getPermissions($this->session->userdata('roleId'),1);
		echo '<pre>'; print_r($permissio); echo '</pre>';
	}


} ?>