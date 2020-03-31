<?php
class Port extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('State_Model','Country_Model','Port_Model'));

		$this->page = $this->config->item("base_url_admin")."port";

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),5);

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
			$data['create'] = "Create";			
		}else{$data['NULL'] = "";}
		
		$data['country'] = $this->Country_Model->getall();
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/port/table',$data,'admin');
	}

	function fetch()
	{

		$fetch_data = $this->Port_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->portCode;
			$sub_array[] = $row->portName;
			$sub_array[] = $row->stateName;
			$sub_array[] = $row->countryName;


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
				if(isset($permission['view']))
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
						$status = '<a href ="'.base_url('admin/port').'/status/activate/'.$row->portId.'" type="submit" name="delete" id="'.$row->portId.'" class="update" ><i class="fa fa-toggle-off"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/port').'/status/deactivate/'.$row->portId.'" type="submit" name="delete" id="'.$row->portId.'" class="update" ><i class="fa fa-toggle-on"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a type="submit" name="edit" id="'.$row->portId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/port').'/delete/'.$row->portId.'" type="submit" name="edit" id="'.$row->portId.'" class="edit" ><i class="fa fa-trash"></i></a>';
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
			"recordsTotal"          =>     $this->Port_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->Port_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function action()
	{
		if($this->input->post('action')=="save")
		{
			$this->Port_Model->save();
		}
		else
		{
			$this->Port_Model->update();
		}
		
		header("Location:".$this->page);
	}


	function status()
	{
		$this->Port_Model->status();
		header("Location:".$this->page);

	}

	function getbyID()
	{
		$data = $this->Port_Model->get($this->input->post("id"));

		$output['country'] = $data->countryId;
		$output['state'] = $data->stateId;
		$output['code'] = $data->portCode;
		$output['port'] = $data->portName;
		echo json_encode($output);
	}

	function delete()
	{
		$this->Port_Model->delete();
		header("Location:".$this->page);
	}

	function checkCode()
	{
		$data = $this->Port_Model->checkCode();

		if($data)
		{
			echo "Already Exists";
		}
		else
		{
			echo "";
		}

	}


} ?>