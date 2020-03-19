<?php
class Module extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('User_Model'));

		$this->page = $this->config->item("base_url_admin")."module";

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),8);

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
		$this->layouts->view('pages/admin/module/table',$data,'admin');
	}

	function fetchModule()
	{

		$fetch_data = $this->User_Model->fetch_dataModule();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->moduleName;
			$sub_array[] = $row->operationName;
			$sub_array[] = $row->tableName;

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
						$status = '<a href ="'.base_url('admin/module').'/status/activate/'.$row->moduleId.'" type="submit" name="delete" id="'.$row->moduleId.'" class="update" ><i class="fa fa-check-square"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/module').'/status/deactivate/'.$row->moduleId.'" type="submit" name="delete" id="'.$row->moduleId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a href ="'.base_url('admin/module').'/edit/'.$row->moduleId.'" type="submit" name="edit" id="'.$row->moduleId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/module').'/delete/'.$row->moduleId.'" type="submit" name="edit" id="'.$row->moduleId.'" class="edit" ><i class="fa fa-trash"></i></a>';
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
			"recordsTotal"          =>     $this->User_Model->get_all_dataModule(),  
			"recordsFiltered"     	=>     $this->User_Model->get_filtered_dataModule(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['tables'] = $this->User_Model->getallTable();
		$data['operations'] = $this->User_Model->getallOperation();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/module/form',$data,'admin');
	}

	function save()
	{
		$this->User_Model->saveModule();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->User_Model->statusModule();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['module'] = $this->User_Model->getModule('specific');
		$data['tables'] = $this->User_Model->getallTable();
		$data['operations'] = $this->User_Model->getallOperation();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/module/form',$data,'admin');
	}

	function update()
	{
		$this->User_Model->updateModule();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->User_Model->deleteModule();
		header("Location:".$this->page);
	}


} ?>